<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - NgopiGo</title>
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --black: #121212;
            --dark-brown: #2E1F1A;
            --gold: #C69C6D;
            --gold-light: #D4AF7A;
            --cream: #F5F0E6;
        }

        .bg-premium-black { background-color: var(--black); }
        .bg-premium-brown { background-color: var(--dark-brown); }
        .bg-premium-gold { background-color: var(--gold); }
        .text-premium-gold { color: var(--gold); }
        .border-premium-gold { border-color: var(--gold); }

        .gradient-gold {
            background: linear-gradient(135deg, #C69C6D 0%, #F5DEB3 50%, #C69C6D 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link.active {
            color: #C69C6D;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #C69C6D;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-premium-black text-[#F5F0E6] min-h-screen">

    <!-- Header -->
    <header class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] border-b border-[#C69C6D]/30 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo & Title -->
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="NgopiGo" class="w-12 h-12 rounded-full border-2 border-[#C69C6D]">
                    @php
                        $currentUser = auth()->guard('admin')->user();
                    @endphp
                    <div>
                        <h1 class="text-2xl font-bold gradient-gold">
                            @if($currentUser && $currentUser->isKitchen())
                                NgopiGo Dapur
                            @elseif($currentUser && $currentUser->isCashier())
                                NgopiGo Kasir
                            @else
                                NgopiGo Admin
                            @endif
                        </h1>
                        <p class="text-[#C69C6D] text-xs">
                            @if($currentUser && $currentUser->isKitchen())
                                🍳 Dapur
                            @elseif($currentUser && $currentUser->isCashier())
                                💵 Kasir
                            @else
                                👑 Administrator
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex items-center gap-6">
                    @if($currentUser && $currentUser->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} text-white hover:text-[#C69C6D] transition font-medium">
                        📊 Dashboard
                    </a>
                    @endif

                    @if($currentUser && ($currentUser->isAdmin() || $currentUser->isCashier()))
                    <a href="{{ route('admin.orders.index') }}"
                       class="nav-link {{ request()->routeIs('admin.orders.*') && !request()->routeIs('admin.history') && !request()->routeIs('*.walkthrough*') ? 'active' : '' }} text-white hover:text-[#C69C6D] transition font-medium">
                        📝 Pesanan
                    </a>
                    @endif

                    @if($currentUser && ($currentUser->isAdmin() || $currentUser->isKitchen()))
                    <a href="{{ route('admin.kitchen') }}"
                       class="nav-link {{ request()->routeIs('admin.kitchen') ? 'active' : '' }} text-white hover:text-[#C69C6D] transition font-medium">
                        🍳 Dapur
                    </a>
                    @endif

                    @if($currentUser && $currentUser->isAdmin())
                    <a href="{{ route('admin.products.index') }}"
                       class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }} text-white hover:text-[#C69C6D] transition font-medium">
                        📦 Produk
                    </a>
                    @endif

                    @if($currentUser && ($currentUser->isAdmin() || $currentUser->isCashier()))
                    <a href="{{ route('admin.history') }}"
                       class="nav-link {{ request()->routeIs('admin.history') ? 'active' : '' }} text-white hover:text-[#C69C6D] transition font-medium">
                        📜 Riwayat
                    </a>
                    @endif
                </nav>

                <!-- User Actions -->
                <div class="flex items-center gap-3">
                    <div class="text-right hidden lg:block">
                        <p class="text-xs text-[#C69C6D]">Halo,</p>
                        <p class="text-sm font-semibold text-white">
                            @if($currentUser)
                                {{ $currentUser->name }}
                            @endif
                        </p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="bg-[#C69C6D] hover:bg-[#D4AF7A] text-[#121212] font-semibold py-2 px-4 rounded-lg transition shadow-lg hover:shadow-[#C69C6D]/50 text-sm">
                            🚪 Logout
                        </button>
                    </form>
                    <a href="{{ route('order.create') }}"
                       class="bg-[#C69C6D]/20 hover:bg-[#C69C6D]/40 border border-[#C69C6D]/50 text-[#F5F0E6] font-semibold py-2 px-4 rounded-lg transition backdrop-blur-sm text-sm">
                        🛒 Website
                    </a>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div class="md:hidden mt-4 pt-4 border-t border-[#C69C6D]/20">
                <div class="flex gap-2 overflow-x-auto pb-2">
                    @if($currentUser && $currentUser->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="whitespace-nowrap px-4 py-2 bg-[#C69C6D]/20 rounded-lg text-sm font-medium hover:bg-[#C69C6D]/30 transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#C69C6D]/40 text-[#C69C6D]' : 'text-white' }}">
                        📊 Dashboard
                    </a>
                    @endif

                    @if($currentUser && ($currentUser->isAdmin() || $currentUser->isCashier()))
                    <a href="{{ route('admin.orders.index') }}"
                       class="whitespace-nowrap px-4 py-2 bg-[#C69C6D]/20 rounded-lg text-sm font-medium hover:bg-[#C69C6D]/30 transition {{ request()->routeIs('admin.orders.*') && !request()->routeIs('admin.history') && !request()->routeIs('*.walkthrough*') ? 'bg-[#C69C6D]/40 text-[#C69C6D]' : 'text-white' }}">
                        📝 Pesanan
                    </a>
                    @endif

                    @if($currentUser && ($currentUser->isAdmin() || $currentUser->isKitchen()))
                    <a href="{{ route('admin.kitchen') }}"
                       class="whitespace-nowrap px-4 py-2 bg-[#C69C6D]/20 rounded-lg text-sm font-medium hover:bg-[#C69C6D]/30 transition {{ request()->routeIs('admin.kitchen') ? 'bg-[#C69C6D]/40 text-[#C69C6D]' : 'text-white' }}">
                        🍳 Dapur
                    </a>
                    @endif

                    @if($currentUser && $currentUser->isAdmin())
                    <a href="{{ route('admin.products.index') }}"
                       class="whitespace-nowrap px-4 py-2 bg-[#C69C6D]/20 rounded-lg text-sm font-medium hover:bg-[#C69C6D]/30 transition {{ request()->routeIs('admin.products.*') ? 'bg-[#C69C6D]/40 text-[#C69C6D]' : 'text-white' }}">
                        📦 Produk
                    </a>
                    @endif

                    @if($currentUser && ($currentUser->isAdmin() || $currentUser->isCashier()))
                    <a href="{{ route('admin.history') }}"
                       class="whitespace-nowrap px-4 py-2 bg-[#C69C6D]/20 rounded-lg text-sm font-medium hover:bg-[#C69C6D]/30 transition {{ request()->routeIs('admin.history') ? 'bg-[#C69C6D]/40 text-[#C69C6D]' : 'text-white' }}">
                        📜 Riwayat
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @if(session('success'))
        <div class="bg-green-900/50 border border-green-500/50 text-green-200 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
            <span class="text-2xl">✅</span>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-900/50 border border-red-500/50 text-red-200 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
            <span class="text-2xl">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-[#C69C6D]/20 mt-12 py-6">
        <div class="container mx-auto px-4 text-center text-[#C69C6D] text-sm">
            <p>&copy; {{ date('Y') }} NgopiGo. All rights reserved.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
