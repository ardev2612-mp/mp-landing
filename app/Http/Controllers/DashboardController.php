<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Services\MidtransService;

class DashboardController extends Controller
{
    /**
     * Plan pricing data.
     */
    private $planData = [
        'free' => ['name' => 'Free', 'price' => 0, 'desc' => 'Untuk mencoba fitur.', 'features' => ['1 Akun Sosmed', '7 Postingan Total', '300 MB Storage']],
        'basic' => ['name' => 'Basic', 'price' => 75000, 'desc' => 'Untuk pemula.', 'features' => ['2 Akun Sosmed', 'Unlimited Postingan', '2 GB Storage']],
        'pro' => ['name' => 'Pro', 'price' => 145000, 'desc' => 'Untuk UMKM serius.', 'features' => ['5 Akun Sosmed', 'Unlimited Postingan', '20 GB Storage']],
        'proplus' => ['name' => 'Pro+', 'price' => 280000, 'desc' => 'Untuk Bisnis Berkembang.', 'features' => ['10 Akun Sosmed', 'Unlimited Postingan', '25 GB Storage', 'Prioritas Support']],
        'advanced' => ['name' => 'Advanced', 'price' => 1500000, 'desc' => 'Untuk Agensi Besar.', 'features' => ['25 Akun Sosmed', 'Unlimited Postingan', '60 GB Storage', 'White-label Report']],
    ];

    /**
     * Dashboard home page.
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $subscription = $customer->currentSubscription();

        // Fallback: if no active subscription, get the latest one
        if (!$subscription) {
            $subscription = $customer->subscriptions()->latest()->first();
        }

        $currentPlan = $subscription ? ($subscription->current_plan ?? $customer->plan_selected) : $customer->plan_selected;
        $planInfo = $this->planData[$currentPlan] ?? $this->planData['free'];

        return view('customer.dashboard', compact('customer', 'subscription', 'currentPlan', 'planInfo'));
    }

    /**
     * Show upgrade plans page.
     */
    public function upgrade()
    {
        $customer = Auth::guard('customer')->user();
        $subscription = $customer->currentSubscription();

        $currentPlan = $subscription ? ($subscription->current_plan ?? $customer->plan_selected) : $customer->plan_selected;

        // Determine available upgrade plans
        $planHierarchy = ['free', 'basic', 'pro', 'proplus', 'advanced'];
        $currentIndex = array_search($currentPlan, $planHierarchy);
        $availablePlans = [];

        if ($currentIndex !== false) {
            foreach (array_slice($planHierarchy, $currentIndex + 1) as $planKey) {
                $availablePlans[$planKey] = $this->planData[$planKey];
            }
        }

        $currentPlanInfo = $this->planData[$currentPlan] ?? $this->planData['free'];

        return view('customer.upgrade', compact('customer', 'currentPlan', 'currentPlanInfo', 'availablePlans', 'subscription'));
    }

    /**
     * Process upgrade request and create Midtrans transaction.
     */
    public function processUpgrade(Request $request)
    {
        $request->validate([
            'plan' => 'required|string|in:basic,pro,proplus,advanced',
        ]);

        $newPlan = $request->input('plan');
        $customer = Auth::guard('customer')->user();
        $currentPlan = $customer->plan_selected;

        // Validate upgrade direction
        $planHierarchy = ['free', 'basic', 'pro', 'proplus', 'advanced'];
        $currentIndex = array_search($currentPlan, $planHierarchy);
        $newIndex = array_search($newPlan, $planHierarchy);

        if ($newIndex === false || $currentIndex === false || $newIndex <= $currentIndex) {
            return back()->withErrors(['plan' => 'Anda hanya bisa upgrade ke paket yang lebih tinggi.']);
        }

        $newPrice = $this->planData[$newPlan]['price'] ?? 0;

        // Deactivate current subscription
        $customer->subscriptions()->where('is_active', true)->update(['is_active' => false]);

        // Create new subscription
        $orderId = 'UPG-' . uniqid();
        $subscription = Subscription::create([
            'registration_id' => $customer->id,
            'midtrans_order_id' => $orderId,
            'amount' => $newPrice,
            'payment_status' => 'pending',
            'current_plan' => $newPlan,
            'is_active' => false,
        ]);

        // Get Midtrans Snap Token
        $midtrans = new MidtransService();
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $newPrice,
            ],
            'customer_details' => [
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'email' => $customer->email,
            ],
            'item_details' => [
                [
                    'id' => $newPlan,
                    'price' => $newPrice,
                    'quantity' => 1,
                    'name' => 'Upgrade MaticPost ' . ucfirst($newPlan) . ' Plan',
                ]
            ]
        ];

        try {
            $snapToken = $midtrans->getSnapToken($params);
            return view('customer.payment', compact('snapToken', 'subscription', 'customer', 'newPlan'));
        } catch (\Exception $e) {
            return back()->withErrors(['payment' => 'Gagal memulai pembayaran: ' . $e->getMessage()]);
        }
    }
}
