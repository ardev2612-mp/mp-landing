    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 glass" id="navbar">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                <img src="{{ asset('assets/img/logo-1.png') }}" alt="MaticPost Logo" class="h-7 md:h-8 w-auto" loading="eager">
                <span
                    class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-brand-600 to-accent-500">MaticPost</span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ url('/#features') }}" class="text-slate-600 hover:text-brand-600 font-medium transition">Fitur</a>
                <a href="{{ url('/#how-it-works') }}" class="text-slate-600 hover:text-brand-600 font-medium transition">Cara
                    Kerja</a>
                <a href="{{ url('/#pricing') }}" class="text-slate-600 hover:text-brand-600 font-medium transition">Harga</a>
            </div>

            <!-- CTA Button -->
            <div class="hidden md:flex items-center gap-4">
                <a href="{{ route('customer.login') }}"
                    class="text-slate-600 hover:text-brand-600 font-medium">Masuk</a>
                <a href="{{ url('/#pricing') }}"
                    class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-full font-medium transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Mulai Gratis
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden text-slate-700 focus:outline-none" onclick="toggleMenu()">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-slate-100 p-4 absolute w-full shadow-lg">
            <a href="{{ url('/#features') }}" class="block py-3 text-slate-600 font-medium">Fitur</a>
            <a href="{{ url('/#pricing') }}" class="block py-3 text-slate-600 font-medium">Harga</a>
            <a href="{{ route('customer.login') }}" class="block py-3 text-brand-600 font-bold">Masuk / Daftar</a>
        </div>
    </nav>
