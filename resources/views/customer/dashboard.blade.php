@extends('layouts.dashboard-layout')

@section('title', 'Dashboard - MaticPost')

@section('content')
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Selamat datang, {{ $customer->first_name }}! 👋</h1>
        <p class="text-slate-500 mt-1">Kelola langganan dan akun MaticPost Anda di sini.</p>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Go to App -->
        <a href="https://app.maticpost.com/maticpost/login" target="_blank" class="group bg-gradient-to-br from-brand-600 to-accent-500 rounded-2xl p-6 text-white shadow-lg shadow-brand-500/20 hover:shadow-xl hover:-translate-y-1 transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-rocket text-xl"></i>
                </div>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition"></i>
            </div>
            <h3 class="font-bold text-lg">Buka MaticPost App</h3>
            <p class="text-white/80 text-sm mt-1">Kelola sosial media Anda</p>
        </a>

        <!-- Current Plan -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-crown text-purple-500 text-xl"></i>
                </div>
                @php
                    $statusColor = match(true) {
                        $subscription && $subscription->payment_status === 'success' => 'bg-green-100 text-green-700',
                        $subscription && $subscription->payment_status === 'pending' => 'bg-yellow-100 text-yellow-700',
                        default => 'bg-slate-100 text-slate-600',
                    };
                    $statusText = match(true) {
                        $subscription && $subscription->payment_status === 'success' => 'Aktif',
                        $subscription && $subscription->payment_status === 'pending' => 'Pending',
                        default => 'Tidak Aktif',
                    };
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">{{ $statusText }}</span>
            </div>
            <h3 class="font-bold text-lg text-slate-900">Paket {{ $planInfo['name'] }}</h3>
            <p class="text-slate-500 text-sm mt-1">
                @if($currentPlan === 'free')
                    Gratis
                @else
                    Rp {{ number_format($planInfo['price'], 0, ',', '.') }}/bulan
                @endif
            </p>
        </div>

        <!-- Upgrade -->
        @php
            $planHierarchy = ['free', 'basic', 'pro', 'proplus', 'advanced'];
            $currentIdx = array_search($currentPlan, $planHierarchy);
            $canUpgrade = $currentIdx !== false && $currentIdx < count($planHierarchy) - 1;
        @endphp
        @if($canUpgrade)
        <a href="{{ route('dashboard.upgrade') }}" class="group bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:border-brand-300 hover:shadow-md hover:-translate-y-1 transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-arrow-up-right-dots text-amber-500 text-xl"></i>
                </div>
                <i class="fas fa-chevron-right text-slate-400 group-hover:text-brand-500 group-hover:translate-x-1 transition"></i>
            </div>
            <h3 class="font-bold text-lg text-slate-900">Upgrade Paket</h3>
            <p class="text-slate-500 text-sm mt-1">Tingkatkan fitur Anda</p>
        </a>
        @else
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
            </div>
            <h3 class="font-bold text-lg text-slate-900">Paket Tertinggi</h3>
            <p class="text-slate-500 text-sm mt-1">Anda sudah di paket tertinggi</p>
        </div>
        @endif
    </div>

    <!-- Subscription Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Plan Features -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h2 class="font-bold text-slate-900 flex items-center gap-2">
                    <i class="fas fa-list-check text-brand-600"></i> Fitur Paket {{ $planInfo['name'] }}
                </h2>
            </div>
            <div class="p-6">
                <ul class="space-y-3">
                    @foreach($planInfo['features'] as $feature)
                    <li class="flex items-center gap-3">
                        <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                            <i class="fas fa-check text-green-600 text-xs"></i>
                        </div>
                        <span class="text-slate-700">{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Subscription Info -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h2 class="font-bold text-slate-900 flex items-center gap-2">
                    <i class="fas fa-receipt text-brand-600"></i> Informasi Langganan
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-sm text-slate-500">Nama</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $customer->full_name }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-sm text-slate-500">Email</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $customer->email }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-sm text-slate-500">Paket</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $planInfo['name'] }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-sm text-slate-500">Status Pembayaran</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">{{ $statusText }}</span>
                </div>
                @if($subscription && $subscription->expires_at)
                <div class="flex justify-between items-center py-2 border-b border-slate-50">
                    <span class="text-sm text-slate-500">Berlaku Sampai</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $subscription->expires_at->format('d M Y') }}</span>
                </div>
                @endif
                @if($subscription && $subscription->midtrans_order_id)
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm text-slate-500">Order ID</span>
                    <span class="text-sm font-mono text-slate-600">{{ $subscription->midtrans_order_id }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
