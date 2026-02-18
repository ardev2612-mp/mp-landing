<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create()
    {
        return view('register');
    }

    /**
     * Store a new registration.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255', // We will add unique validation later when mapped to Mixpost
            'password' => 'required|string|min:8|confirmed',
            'business_type' => 'required|string',
            'job_title' => 'required|string',
            'plan' => 'required|string',
        ]);

        $registration = Registration::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'business_type' => $validated['business_type'],
            'job_title' => $validated['job_title'],
            'plan_selected' => $validated['plan'],
            'status' => 'pending',
        ]);

        // Create Subscription Record
        $orderId = 'SUB-' . uniqid();
        $subscription = \App\Models\Subscription::create([
            'registration_id' => $registration->id,
            'midtrans_order_id' => $orderId,
            'amount' => $this->getPlanPrice($validated['plan']),
            'payment_status' => 'pending',
            'current_plan' => $validated['plan'],
            'is_active' => false,
        ]);

        // Get Midtrans Snap Token
        $midtrans = new \App\Services\MidtransService();
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $subscription->amount,
            ],
            'customer_details' => [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => '08123456789', // Placeholder as we didn't ask for phone yet
            ],
            'item_details' => [
                [
                    'id' => $validated['plan'],
                    'price' => $subscription->amount,
                    'quantity' => 1,
                    'name' => 'MaticPost ' . ucfirst($validated['plan']) . ' Plan',
                ]
            ]
        ];

        try {
            $snapToken = $midtrans->getSnapToken($params);
            return view('payment', compact('snapToken', 'subscription', 'registration'));
        } catch (\Exception $e) {
            return back()->withErrors(['payment' => 'Failed to initiate payment: ' . $e->getMessage()]);
        }
    }

    private function getPlanPrice($plan)
    {
        // Monthly prices for now
        $prices = [
            'free' => 0,
            'basic' => 75000,
            'pro' => 145000,
            'proplus' => 280000,
            'advanced' => 1500000,
        ];
        return $prices[$plan] ?? 0;
    }
}
