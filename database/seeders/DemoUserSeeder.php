<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Registration;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $registration = Registration::create([
            'first_name' => 'Demo',
            'last_name' => 'User',
            'email' => 'demo@maticpost.com',
            'password' => Hash::make('password123'),
            'business_type' => 'technology',
            'job_title' => 'Owner',
            'plan_selected' => 'basic',
            'status' => 'active',
        ]);

        Subscription::create([
            'registration_id' => $registration->id,
            'midtrans_order_id' => 'SUB-DEMO-001',
            'amount' => 75000,
            'payment_status' => 'success',
            'current_plan' => 'basic',
            'is_active' => true,
            'expires_at' => now()->addMonth(),
        ]);
    }
}
