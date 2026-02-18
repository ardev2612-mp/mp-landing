@extends('layouts.dashboard-layout')

@section('title', 'Upgrade Paket - MaticPost')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-brand-600 mb-4 transition">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Upgrade Paket</h1>
        <p class="text-slate-500 mt-1">Tingkatkan paket Anda untuk fitur dan kapasitas lebih besar.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
            @foreach ($errors->all() as $error)
                <p class="flex items-center gap-2"><i class="fas fa-exclamation-circle"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Current Plan -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-2xl p-6 mb-8 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500 rounded-full blur-3xl opacity-20 -mr-16 -mt-16"></div>
        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-slate-400 text-xs uppercase tracking-widest mb-1">Paket Saat Ini</p>
                <h2 class="text-2xl font-bold">{{ $currentPlanInfo['name'] }}</h2>
                <p class="text-slate-300 text-sm mt-1">{{ $currentPlanInfo['desc'] }}</p>
            </div>
            <div class="flex items-center gap-2">
                @foreach($currentPlanInfo['features'] as $feature)
                    <span class="px-3 py-1 bg-white/10 rounded-full text-xs text-slate-300 hidden md:inline-block">{{ $feature }}</span>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Available Upgrades -->
    @if(count($availablePlans) > 0)
    <h2 class="text-lg font-bold text-slate-900 mb-4">Pilih Paket Upgrade</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($availablePlans as $planKey => $plan)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:border-brand-300 transition duration-300 overflow-hidden flex flex-col {{ $planKey === 'pro' ? 'ring-2 ring-brand-500 relative' : '' }}">
            @if($planKey === 'pro')
            <div class="bg-brand-600 text-white text-center py-1.5 text-xs font-bold uppercase tracking-wider">
                <i class="fas fa-star mr-1"></i> Paling Populer
            </div>
            @endif

            <div class="p-6 flex-1 flex flex-col">
                <div class="mb-4">
                    <h3 class="text-xl font-bold text-slate-900">{{ $plan['name'] }}</h3>
                    <p class="text-slate-500 text-sm mt-1">{{ $plan['desc'] }}</p>
                </div>

                <div class="mb-6">
                    <span class="text-3xl font-bold text-slate-900">Rp {{ number_format($plan['price'], 0, ',', '.') }}</span>
                    <span class="text-slate-500 text-sm">/bulan</span>
                </div>

                <ul class="space-y-3 mb-6 flex-1">
                    @foreach($plan['features'] as $feature)
                    <li class="flex items-center gap-3 text-sm">
                        <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                            <i class="fas fa-check text-green-600 text-[10px]"></i>
                        </div>
                        <span class="text-slate-700">{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>

                <form action="{{ route('dashboard.upgrade.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="plan" value="{{ $planKey }}">
                    <button type="submit"
                        class="w-full {{ $planKey === 'pro' ? 'bg-gradient-to-r from-brand-600 to-accent-500 hover:from-brand-700 hover:to-accent-600 shadow-lg shadow-brand-500/20' : 'bg-slate-900 hover:bg-slate-800' }} text-white font-bold py-3 rounded-xl transform hover:-translate-y-0.5 transition duration-200">
                        Upgrade ke {{ $plan['name'] }}
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-12 text-center">
        <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-check-circle text-green-500 text-3xl"></i>
        </div>
        <h2 class="text-xl font-bold text-slate-900 mb-2">Anda di Paket Tertinggi!</h2>
        <p class="text-slate-500">Anda sudah menggunakan paket Advanced, paket tertinggi dari MaticPost. Nikmati semua fitur tanpa batas.</p>
    </div>
    @endif
@endsection
