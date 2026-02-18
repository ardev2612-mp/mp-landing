<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Handle payment status page (for both registration and upgrade).
     */
    public function status(Request $request)
    {
        $status = $request->query('status', 'pending');
        $orderId = $request->query('order_id');

        $subscription = null;
        if ($orderId) {
            $subscription = Subscription::where('midtrans_order_id', $orderId)->first();
        }

        return view('customer.payment-status', compact('status', 'orderId', 'subscription'));
    }

    /**
     * Handle Midtrans notification callback.
     */
    public function callback(Request $request)
    {
        try {
            // Set Midtrans configuration
            $midtrans = new \App\Services\MidtransService();

            $notification = new Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            $subscription = Subscription::where('midtrans_order_id', $orderId)->first();

            if (!$subscription) {
                Log::warning('Midtrans callback: subscription not found for order ' . $orderId);
                return response()->json(['message' => 'Subscription not found'], 404);
            }

            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                if ($fraudStatus == 'accept' || $fraudStatus == null) {
                    $subscription->update([
                        'payment_status' => 'success',
                        'is_active' => true,
                        'expires_at' => now()->addMonth(),
                    ]);

                    // Update the registration's plan_selected
                    $registration = $subscription->registration;
                    if ($registration && $subscription->current_plan) {
                        $registration->update([
                            'plan_selected' => $subscription->current_plan,
                            'status' => 'active',
                        ]);
                    }
                }
            } elseif ($transactionStatus == 'pending') {
                $subscription->update(['payment_status' => 'pending']);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $subscription->update([
                    'payment_status' => 'failed',
                    'is_active' => false,
                ]);
            }

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            Log::error('Midtrans callback error: ' . $e->getMessage());
            return response()->json(['message' => 'Error'], 500);
        }
    }
}
