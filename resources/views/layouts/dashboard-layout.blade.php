<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - MaticPost')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-1.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            900: '#0c4a6e',
                        },
                        accent: {
                            500: '#6366f1',
                            600: '#4f46e5',
                        }
                    },
                }
            }
        }
    </script>

    <style>
        .sidebar-link {
            transition: all 0.2s ease;
        }
        .sidebar-link:hover,
        .sidebar-link.active {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(99, 102, 241, 0.1));
            color: #0284c7;
        }
        .sidebar-link.active {
            border-right: 3px solid #0284c7;
        }
    </style>
    @stack('styles')
</head>

<body class="font-sans text-slate-800 bg-slate-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white border-r border-slate-200 fixed h-full z-30 transition-transform duration-300 lg:translate-x-0 -translate-x-full">
            <!-- Logo -->
            <div class="p-6 border-b border-slate-100">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('assets/img/logo-1.png') }}" alt="MaticPost Logo" class="h-7 w-auto">
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-brand-600 to-accent-500">MaticPost</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-600 {{ request()->routeIs('dashboard') && !request()->routeIs('dashboard.upgrade') ? 'active' : '' }}">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('dashboard.upgrade') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-600 {{ request()->routeIs('dashboard.upgrade') ? 'active' : '' }}">
                    <i class="fas fa-arrow-up-right-dots w-5 text-center"></i>
                    <span>Upgrade Paket</span>
                </a>

                <div class="pt-4 mt-4 border-t border-slate-100">
                    <a href="https://app.maticpost.com/maticpost/login" target="_blank" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-brand-600 bg-brand-50 hover:bg-brand-100">
                        <i class="fas fa-external-link-alt w-5 text-center"></i>
                        <span>Buka Aplikasi MaticPost</span>
                    </a>
                </div>
            </nav>

            <!-- Bottom User Section -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-100 bg-white">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-brand-500 to-accent-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::guard('customer')->user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::guard('customer')->user()->last_name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ Auth::guard('customer')->user()->full_name }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ Auth::guard('customer')->user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('customer.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 justify-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64">
            <!-- Top Bar (Mobile) -->
            <header class="bg-white border-b border-slate-200 px-6 py-4 lg:hidden flex items-center justify-between">
                <button onclick="toggleSidebar()" class="text-slate-600 hover:text-slate-800">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('assets/img/logo-1.png') }}" alt="MaticPost Logo" class="h-6 w-auto">
                    <span class="text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-brand-600 to-accent-500">MaticPost</span>
                </a>
                <div class="w-8"></div>
            </header>

            <!-- Page Content -->
            <main class="p-6 md:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
    @stack('scripts')
</body>

</html>
