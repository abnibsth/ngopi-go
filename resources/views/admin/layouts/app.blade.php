<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — NgopiGo</title>
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --black:      #0e0c0a;
            --dark-brown: #1e1410;
            --mid-brown:  #2a1c16;
            --gold:       #b8924a;
            --gold-light: #d4af7a;
            --gold-pale:  #e8d5b0;
            --cream:      #f4ede3;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--black);
            color: var(--cream);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, .font-serif {
            font-family: 'Playfair Display', serif;
        }

        .gradient-gold {
            background: linear-gradient(120deg, #b8924a 0%, #e8d5b0 45%, #c4a265 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Sleek Header */
        header {
            background: rgba(30,20,16,0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(184,146,74,0.15);
        }

        /* Nav Links */
        .nav-link {
            position: relative;
            color: rgba(244,237,227,0.7);
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0;
        }
        .nav-link:hover {
            color: var(--gold-pale);
        }
        .nav-link.active {
            color: var(--gold);
            font-weight: 500;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        .nav-link.active::after {
            width: 100%;
        }

        /* Custom Icons */
        .icon-sm { width: 1.1rem; height: 1.1rem; }
        .icon-md { width: 1.4rem; height: 1.4rem; }

        /* Role Badge */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.15rem 0.6rem;
            border-radius: 1rem;
            background: rgba(184,146,74,0.1);
            border: 1px solid rgba(184,146,74,0.2);
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--gold);
        }

        /* Alerts */
        @keyframes slideDownAlert {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .system-alert {
            animation: slideDownAlert 0.4s cubic-bezier(0.23, 1, 0.32, 1) both;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        .alert-success {
            background: rgba(74,222,128,0.1);
            border: 1px solid rgba(74,222,128,0.25);
            color: #86efac;
        }
        .alert-error {
            background: rgba(248,113,113,0.1);
            border: 1px solid rgba(248,113,113,0.25);
            color: #fca5a5;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Header -->
    <header class="sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 sm:py-4">
            <div class="flex items-center justify-between">
                <!-- Logo & Title -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="NgopiGo" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border border-[var(--gold)] shadow-[0_0_15px_rgba(184,146,74,0.2)]">
                    @php
                        $currentUser = auth()->guard('admin')->user();
                    @endphp
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold gradient-gold leading-none mb-1">
                            @if($currentUser && $currentUser->isKitchen())
                                NgopiGo Dapur
                            @elseif($currentUser && $currentUser->isCashier())
                                NgopiGo Kasir
                            @else
                                NgopiGo Admin
                            @endif
                        </h1>
                        <div class="role-badge">
                            @if($currentUser && $currentUser->isKitchen())
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                                </svg>
                                Dapur
                            @elseif($currentUser && $currentUser->isCashier())
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Kasir
                            @else
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                                Administrator
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    @if($currentUser && $currentUser->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                        </svg>
                        Dashboard
                    </a>
                    @endif

                    @if($currentUser && ($currentUser->isAdmin() || $currentUser->isCashier()))
                    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') && !request()->routeIs('admin.history') && !request()->routeIs('*.walkthrough*') ? 'active' : '' }}">
                        <svg class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75M6.75 21h9" />
                        </svg>
                        Pesanan
                    </a>
                    @endif

                    @if($currentUser && ($currentUser->isAdmin() || $currentUser->isKitchen()))
                    <a href="{{ route('admin.kitchen') }}" class="nav-link {{ request()->routeIs('admin.kitchen') ? 'active' : '' }}">
                        <svg class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                        </svg>
                        Dapur
                    </a>
                    @endif

                    @if($currentUser && $currentUser->isAdmin())
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <svg class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        Produk
                    </a>
                    @endif

                    @if($currentUser && ($currentUser->isAdmin() || $currentUser->isCashier()))
                    <a href="{{ route('admin.history') }}" class="nav-link {{ request()->routeIs('admin.history') ? 'active' : '' }}">
                        <svg class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Riwayat
                    </a>
                    @endif
                </nav>

                <!-- User Actions -->
                <div class="flex items-center gap-3">
                    <div class="text-right hidden lg:block mr-2">
                        <p class="text-[0.65rem] text-[var(--gold)] uppercase tracking-wider">Selamat Datang</p>
                        <p class="text-sm font-semibold text-white">
                            @if($currentUser)
                                {{ $currentUser->name }}
                            @endif
                        </p>
                    </div>
                    
                    <a href="{{ route('order.create') }}" class="hidden sm:flex items-center justify-center w-9 h-9 rounded-full bg-[rgba(184,146,74,0.1)] hover:bg-[rgba(184,146,74,0.2)] text-[var(--gold)] border border-[rgba(184,146,74,0.2)] transition-colors" title="Lihat Website">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </a>

                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-[var(--gold)] to-[var(--gold-light)] hover:from-[var(--gold-light)] hover:to-[var(--gold)] text-[var(--black)] font-semibold py-1.5 px-4 rounded-lg transition-all shadow-[0_4px_12px_rgba(184,146,74,0.2)] hover:shadow-[0_6px_16px_rgba(184,146,74,0.3)] hover:-translate-y-0.5 text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div class="md:hidden mt-3 pt-3 border-t border-[rgba(184,146,74,0.15)]">
                <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
                    @if($currentUser && $currentUser->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-medium border transition-colors flex items-center gap-1.5 {{ request()->routeIs('admin.dashboard') ? 'bg-[rgba(184,146,74,0.15)] text-[var(--gold)] border-[var(--gold)]' : 'bg-transparent text-[rgba(244,237,227,0.6)] border-[rgba(184,146,74,0.2)]' }}">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                        </svg>
                        Dashboard
                    </a>
                    @endif

                    @if($currentUser && ($currentUser->isAdmin() || $currentUser->isCashier()))
                    <a href="{{ route('admin.orders.index') }}" class="whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-medium border transition-colors flex items-center gap-1.5 {{ request()->routeIs('admin.orders.*') && !request()->routeIs('admin.history') && !request()->routeIs('*.walkthrough*') ? 'bg-[rgba(184,146,74,0.15)] text-[var(--gold)] border-[var(--gold)]' : 'bg-transparent text-[rgba(244,237,227,0.6)] border-[rgba(184,146,74,0.2)]' }}">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75M6.75 21h9" />
                        </svg>
                        Pesanan
                    </a>
                    @endif

                    @if($currentUser && ($currentUser->isAdmin() || $currentUser->isKitchen()))
                    <a href="{{ route('admin.kitchen') }}" class="whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-medium border transition-colors flex items-center gap-1.5 {{ request()->routeIs('admin.kitchen') ? 'bg-[rgba(184,146,74,0.15)] text-[var(--gold)] border-[var(--gold)]' : 'bg-transparent text-[rgba(244,237,227,0.6)] border-[rgba(184,146,74,0.2)]' }}">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                        </svg>
                        Dapur
                    </a>
                    @endif

                    @if($currentUser && $currentUser->isAdmin())
                    <a href="{{ route('admin.products.index') }}" class="whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-medium border transition-colors flex items-center gap-1.5 {{ request()->routeIs('admin.products.*') ? 'bg-[rgba(184,146,74,0.15)] text-[var(--gold)] border-[var(--gold)]' : 'bg-transparent text-[rgba(244,237,227,0.6)] border-[rgba(184,146,74,0.2)]' }}">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        Produk
                    </a>
                    @endif

                    @if($currentUser && ($currentUser->isAdmin() || $currentUser->isCashier()))
                    <a href="{{ route('admin.history') }}" class="whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-medium border transition-colors flex items-center gap-1.5 {{ request()->routeIs('admin.history') ? 'bg-[rgba(184,146,74,0.15)] text-[var(--gold)] border-[var(--gold)]' : 'bg-transparent text-[rgba(244,237,227,0.6)] border-[rgba(184,146,74,0.2)]' }}">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Riwayat
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 flex-1">
        <!-- Alerts -->
        @if(session('success'))
        <div class="system-alert alert-success">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        @if(session('error'))
        <div class="system-alert alert-error">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
            <div>{{ session('error') }}</div>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-[rgba(184,146,74,0.15)] py-6 mt-auto">
        <div class="container mx-auto px-4 text-center text-xs tracking-wide text-[rgba(184,146,74,0.5)]">
            <p>&copy; {{ date('Y') }} NgopiGo. Crafted with precision.</p>
        </div>
    </footer>

    <!-- Script to auto dismiss alerts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.system-alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 500);
                }, 4000);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
