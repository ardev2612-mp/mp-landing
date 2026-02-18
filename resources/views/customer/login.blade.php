@extends('layouts.app')

@section('title', 'Login - MaticPost Dashboard')

@section('navbar')
    <!-- Navbar (Simplified) -->
    <nav class="w-full relative z-50 bg-white border-b border-slate-100">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('assets/img/logo-1.png') }}" alt="MaticPost Logo" class="h-7 md:h-8 w-auto">
                <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-brand-600 to-accent-500">MaticPost</span>
            </a>
            <a href="{{ route('register') }}" class="text-sm font-semibold text-slate-600 hover:text-brand-600">
                Belum punya akun? Daftar
            </a>
        </div>
    </nav>
@endsection

@section('content')
    <main class="flex-grow container mx-auto px-6 py-12 flex items-center justify-center min-h-[70vh]">
        <div class="max-w-md w-full">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-brand-500/20 p-2">
                    <img src="{{ asset('assets/img/logo-1.png') }}" alt="MaticPost Logo" class="h-10 w-auto">
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Masuk ke Dashboard</h1>
                <p class="text-slate-500 mt-2">Kelola langganan MaticPost Anda</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-8">
                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-exclamation-circle"></i>
                            <strong>Login gagal</strong>
                        </div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('customer.login.post') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 outline-none transition"
                                placeholder="name@company.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="password" name="password" required
                                class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 outline-none transition"
                                placeholder="Masukkan password">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                            <span class="text-sm text-slate-600">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-brand-600 to-accent-500 hover:from-brand-700 hover:to-accent-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-brand-500/30 transform hover:-translate-y-0.5 transition duration-200">
                        Masuk
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                    <p class="text-sm text-slate-500">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-brand-600 font-semibold hover:underline">Daftar sekarang</a>
                    </p>
                </div>
            </div>
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
