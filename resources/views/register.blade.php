@extends('layouts.app')

@section('title', 'Daftar - MaticPost')

@section('navbar')
    <!-- Navbar (Simplified) -->
    <nav class="w-full relative z-50 bg-white border-b border-slate-100">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('assets/img/logo-1.png') }}" alt="MaticPost Logo" class="h-7 md:h-8 w-auto">
                <span
                    class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-brand-600 to-accent-500">MaticPost</span>
            </a>
            <a href="{{ route('customer.login') }}" class="text-sm font-semibold text-slate-600 hover:text-brand-600">
                Sudah punya akun? Masuk
            </a>
        </div>
    </nav>
@endsection

@section('content')
    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-6 py-12">
        <div class="max-w-5xl mx-auto flex flex-col lg:flex-row gap-12 items-start">

            <!-- Left Side: Pricing Summary -->
            <div class="lg:w-1/3 w-full top-24">
                <div
                    class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
                    <!-- Background Shapes -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500 rounded-full blur-3xl opacity-20 -mr-16 -mt-16">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 w-32 h-32 bg-accent-500 rounded-full blur-3xl opacity-20 -ml-16 -mb-16">
                    </div>

                    <h3 id="summary-plan-title" class="text-2xl font-bold mb-1">...</h3>
                    <div id="summary-plan-price" class="flex items-baseline gap-1 mb-4">
                        <span class="text-lg font-bold">Rp</span>
                        <span id="price-amount" class="text-3xl font-extrabold text-white">0</span>
                        <span id="price-period" class="text-slate-400 text-sm">/bulan</span>
                    </div>
                    <p id="summary-plan-desc" class="text-slate-300 mb-8 leading-relaxed">...</p>

                    <div id="summary-plan-features" class="space-y-4 mb-8">
                        <!-- Dynamic features will be inserted here -->
                    </div>

                    <!-- Selected Plan Card Mockup -->
                    <div class="mt-8 pt-8 border-t border-slate-700">
                        <p class="text-xs text-slate-400 uppercase tracking-widest mb-2">Paket Dipilih</p>
                        <div class="relative">
                            <select id="plan-selector"
                                class="w-full bg-slate-800 text-white font-bold text-xl py-3 px-4 pr-10 rounded-xl border border-slate-600 focus:outline-none focus:border-brand-500 appearance-none cursor-pointer transition hover:bg-slate-700">
                                <option value="free">Free</option>
                                <option value="basic">Basic</option>
                                <option value="pro">Pro</option>
                                <option value="proplus">Pro+</option>
                                <option value="advanced">Advanced</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="lg:w-2/3 w-full">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
                    <div class="mb-8">
                        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 mb-2">
                            Daftar Paket <span id="form-plan-name" class="text-brand-600">...</span>
                        </h1>
                        <p class="text-slate-500">Lengkapi data diri Anda untuk memulai.</p>
                    </div>

                    <form action="{{ route('register.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="plan" id="input-plan" value="">

                        <!-- Name Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="firstName" class="block text-sm font-medium text-slate-700 mb-2">Nama
                                    Depan</label>
                                <input type="text" id="firstName" name="first_name" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 outline-none transition"
                                    placeholder="Jhon">
                            </div>
                            <div>
                                <label for="lastName" class="block text-sm font-medium text-slate-700 mb-2">Nama
                                    Belakang</label>
                                <input type="text" id="lastName" name="last_name" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 outline-none transition"
                                    placeholder="Doe">
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Alamat Email</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 outline-none transition"
                                placeholder="name@company.com">
                        </div>

                        <!-- Password Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                                <input type="password" id="password" name="password" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 outline-none transition"
                                    placeholder="Min. 8 karakter">
                            </div>
                            <div>
                                <label for="confirmPassword" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi
                                    Password</label>
                                <input type="password" id="confirmPassword" name="password_confirmation" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 outline-none transition"
                                    placeholder="Ulangi password">
                            </div>
                        </div>

                        <!-- Job / Business Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="businessType" class="block text-sm font-medium text-slate-700 mb-2">Bidang
                                    Usaha</label>
                                <select id="businessType" name="business_type" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 outline-none transition bg-white">
                                    <option value="" disabled selected>Pilih Bidang Usaha...</option>
                                    <option value="technology">Teknologi / Software</option>
                                    <option value="fnb">Makanan & Minuman (F&B)</option>
                                    <option value="retail">Retail / Toko Online</option>
                                    <option value="services">Jasa Professional</option>
                                    <option value="education">Pendidikan</option>
                                    <option value="health">Kesehatan & Kecantikan</option>
                                    <option value="agency">Agensi Marketing/Creative</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label for="jobTitle" class="block text-sm font-medium text-slate-700 mb-2">Job
                                    Title</label>
                                <input type="text" id="jobTitle" name="job_title" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-brand-500 focus:ring-2 focus:ring-brand-200 outline-none transition"
                                    placeholder="Contoh: Owner, Marketing Manager">
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" id="btn-submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5 transition duration-200">
                                Buat Akun & Lanjut Pembayaran
                            </button>
                        </div>

                        <p class="text-center text-sm text-slate-500 mt-6">
                            Dengan mendaftar, Anda menyetujui <a href="{{ url('/terms') }}"
                                class="text-brand-600 hover:underline">Syarat
                                & Ketentuan</a> dan <a href="{{ url('/privacy') }}"
                                class="text-brand-600 hover:underline">Kebijakan
                                Privasi</a> kami.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('footer')
    <!-- Simple Footer -->
    <footer class="bg-white border-t border-slate-100 py-8 mt-auto">
        <div class="container mx-auto px-6 text-center text-slate-500 text-sm">
            &copy; {{ date('Y') }} MaticPost Indonesia. All rights reserved.
        </div>
    </footer>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const planParam = urlParams.get('plan') || 'free';

            const planSelector = document.getElementById('plan-selector');
            const formPlanName = document.getElementById('form-plan-name');
            const inputPlan = document.getElementById('input-plan');

            const summaryTitle = document.getElementById('summary-plan-title');
            const summaryPrice = document.getElementById('summary-plan-price');
            const priceAmount = document.getElementById('price-amount');
            const summaryDesc = document.getElementById('summary-plan-desc');
            const summaryFeatures = document.getElementById('summary-plan-features');

            const planData = {
                'free': {
                    name: 'Free',
                    price: '0',
                    desc: 'Untuk mencoba fitur.',
                    features: ['1 Akun Sosmed (1 Facebook, 1 Instagram, 1 TikTok, 1 Youtube)', '7 Postingan Total', '300 MB Storage', 'Jadwal Posting', 'Analitik Dasar']
                },
                'basic': {
                    name: 'Basic',
                    price: '75.000',
                    desc: 'Untuk pemula.',
                    features: ['2 Akun Sosmed (2 Facebook, 2 Instagram, 2 TikTok, 2 Youtube)', 'Unlimited Postingan', '2 GB Storage', 'Jadwal Posting', 'Analitik Dasar']
                },
                'pro': {
                    name: 'Pro',
                    price: '145.000',
                    desc: 'Untuk UMKM serius.',
                    features: ['5 Akun Sosmed (5 Facebook, 5 Instagram, 5 TikTok, 5 Youtube)', 'Unlimited Postingan', '20 GB Storage', 'Jadwal Posting', 'Analitik Dasar']
                },
                'proplus': {
                    name: 'Pro+',
                    price: '280.000',
                    desc: 'Untuk Bisnis Berkembang.',
                    features: ['10 Akun Sosmed (10 Facebook, 10 Instagram, 10 TikTok, 10 Youtube)', 'Unlimited Postingan', '25 GB Storage', 'Prioritas Support', 'Jadwal Posting', 'Analitik Dasar']
                },
                'advanced': {
                    name: 'Advanced',
                    price: '1.500.000',
                    desc: 'Untuk Agensi Besar.',
                    features: ['25 Akun Sosmed (25 Facebook, 25 Instagram, 25 TikTok, 25 Youtube)', 'Unlimited Postingan', '60 GB Storage', 'White-label Report', 'Jadwal Posting', 'Analitik Dasar']
                }
            };

            const updateUI = (plan) => {
                const data = planData[plan] || planData['free'];

                // Update Select
                planSelector.value = plan;

                // Update Form
                formPlanName.textContent = data.name;
                inputPlan.value = plan;

                // Update Sidebar
                summaryTitle.textContent = `Paket ${data.name}`;
                priceAmount.textContent = data.price;
                summaryDesc.textContent = data.desc;

                summaryFeatures.innerHTML = '';
                data.features.forEach(feat => {
                    const featEl = document.createElement('div');
                    featEl.className = 'flex items-center gap-3';
                    featEl.innerHTML = `
                    <div class="w-6 h-6 rounded-full bg-slate-700/50 flex items-center justify-center shrink-0">
                        <i class="fas fa-check text-green-400 text-xs"></i>
                    </div>
                    <span class="text-sm text-slate-300 font-medium">${feat}</span>
                `;
                    summaryFeatures.appendChild(featEl);
                });
            };

            // Initial Update
            updateUI(planParam);

            // Listen for changes
            planSelector.addEventListener('change', (e) => {
                const newPlan = e.target.value;
                updateUI(newPlan);

                // Update URL parameter without reload
                const newUrl = new URL(window.location);
                newUrl.searchParams.set('plan', newPlan);
                window.history.pushState({}, '', newUrl);
            });

            // Form Validation Logic
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('btn-submit');
            const inputs = form.querySelectorAll('input[required], select[required]');

            const checkForm = () => {
                let isValid = true;
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                    }
                });

                if (isValid) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    submitBtn.classList.add('hover:from-blue-700', 'hover:to-indigo-800', 'hover:-translate-y-0.5', 'shadow-lg');
                } else {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    submitBtn.classList.remove('hover:from-blue-700', 'hover:to-indigo-800', 'hover:-translate-y-0.5', 'shadow-lg');
                }
            };

            inputs.forEach(input => {
                input.addEventListener('input', checkForm);
                input.addEventListener('change', checkForm);
            });

            // Initial check
            checkForm();
        });
    </script>
@endpush
