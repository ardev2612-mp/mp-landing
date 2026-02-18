@extends('layouts.app')

@section('title', 'Status Pembayaran - MaticPost')

@section('navbar')
    <nav class="w-full relative z-50 bg-white border-b border-slate-100">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('assets/img/logo-1.png') }}" alt="MaticPost Logo" class="h-7 md:h-8 w-auto">
                <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-brand-600 to-accent-500">MaticPost</span>
            </a>
        </div>
    </nav>
@endsection

@section('content')
    <main class="flex-grow container mx-auto px-6 py-12 flex items-center justify-center min-h-[60vh]">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center border border-slate-100">
            @if($status === 'success')
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check-circle text-green-500 text-4xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 mb-2">Pembayaran Berhasil!</h1>
                <p class="text-slate-500 mb-6">Terima kasih! Pembayaran Anda telah berhasil diproses.</p>
                @if($orderId)
                    <p class="text-xs text-slate-400 mb-6">Order ID: <span class="font-mono">{{ $orderId }}</span></p>
                @endif
                <div class="space-y-3">
                    <a href="{{ route('dashboard') }}" class="block w-full bg-gradient-to-r from-brand-600 to-accent-500 hover:from-brand-700 hover:to-accent-600 text-white font-bold py-3 rounded-xl shadow-lg transition">
                        Ke Dashboard
                    </a>
                    <a href="https://app.maticpost.com/maticpost/login" class="block w-full border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold py-3 rounded-xl transition">
                        Buka Aplikasi MaticPost
                    </a>
                </div>
            @elseif($status === 'pending')
                <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-clock text-yellow-500 text-4xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 mb-2">Menunggu Pembayaran</h1>
                <p class="text-slate-500 mb-6">Kami sedang menunggu konfirmasi pembayaran Anda. Silakan selesaikan pembayaran sesuai instruksi.</p>
                @if($orderId)
                    <p class="text-xs text-slate-400 mb-6">Order ID: <span class="font-mono">{{ $orderId }}</span></p>
                @endif
                <a href="{{ route('dashboard') }}" class="block w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 rounded-xl transition">
                    Kembali ke Dashboard
                </a>
            @else
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-times-circle text-red-500 text-4xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 mb-2">Pembayaran Gagal</h1>
                <p class="text-slate-500 mb-6">Maaf, pembayaran Anda gagal diproses. Silakan coba lagi.</p>
                @if($orderId)
                    <p class="text-xs text-slate-400 mb-6">Order ID: <span class="font-mono">{{ $orderId }}</span></p>
                @endif
                <a href="{{ route('dashboard') }}" class="block w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 rounded-xl transition">
                    Kembali ke Dashboard
                </a>
            @endif
        </div>
    </main>
@endsection

@section('footer')
    <footer class="bg-white border-t border-slate-100 py-8 mt-auto">
        <div class="container mx-auto px-6 text-center text-slate-500 text-sm">
            &copy; {{ date('Y') }} MaticPost Indonesia. All rights reserved.
        </div>
    </footer>
@endsection
