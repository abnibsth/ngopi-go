<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NgopiGo - Premium Coffee & Bites</title>
            <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom Premium Colors */
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
        
        /* Hero Slider Animation */
        @keyframes slideLeft {
            0% { transform: translateX(100%); opacity: 0; }
            10% { transform: translateX(0); opacity: 1; }
            90% { transform: translateX(0); opacity: 1; }
            100% { transform: translateX(-100%); opacity: 0; }
        }
        
        .hero-slide {
            animation: slideLeft 12s infinite;
        }
        
        .hero-slide:nth-child(2) {
            animation-delay: 4s;
        }
        
        .hero-slide:nth-child(3) {
            animation-delay: 8s;
        }
        
        /* Gradient Text */
        .gradient-gold {
            background: linear-gradient(135deg, #C69C6D 0%, #F5DEB3 50%, #C69C6D 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Premium Card Hover */
        .premium-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .premium-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(198, 156, 109, 0.2);
        }
        
        /* Gold Border Animation */
        .gold-border-animate {
            position: relative;
        }
        
        .gold-border-animate::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(45deg, #C69C6D, #F5DEB3, #C69C6D);
            background-size: 200% 200%;
            border-radius: inherit;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
            animation: gradientShift 3s ease infinite;
        }
        
        .gold-border-animate:hover::before {
            opacity: 1;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Scrollbar Custom */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--dark-brown);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 4px;
        }
        
        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Scroll Reveal Animation */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Product Card Animation - Staggered entrance */
        .product-card {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
            animation: productFadeIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .product-card:nth-child(1) { animation-delay: 0.1s; }
        .product-card:nth-child(2) { animation-delay: 0.2s; }
        .product-card:nth-child(3) { animation-delay: 0.3s; }
        .product-card:nth-child(4) { animation-delay: 0.4s; }
        .product-card:nth-child(5) { animation-delay: 0.5s; }
        .product-card:nth-child(6) { animation-delay: 0.6s; }

        @keyframes productFadeIn {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Ensure product cards maintain square shape */
        .product-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-card .aspect-square {
            flex-shrink: 0;
        }

        .product-card > div:last-child {
            flex: 1;
        }

        /* Product Image Zoom Animation */
        .product-image {
            transition: transform 0.5s ease;
        }

        .premium-card:hover .product-image {
            transform: scale(1.05);
        }

        /* Ripple Effect on Click */
        .premium-card {
            position: relative;
            overflow: hidden;
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(198, 156, 109, 0.4) 0%, transparent 70%);
            transform: scale(0);
            animation: rippleEffect 0.6s ease-out;
            pointer-events: none;
        }

        @keyframes rippleEffect {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Glow Effect on Hover */
        .premium-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at var(--mouse-x, 50%) var(--mouse-y, 50%), rgba(198, 156, 109, 0.15) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .premium-card:hover::after {
            opacity: 1;
        }

        /* Pulse Animation for Price */
        @keyframes pulseGold {
            0%, 100% {
                filter: drop-shadow(0 0 0 transparent);
            }
            50% {
                filter: drop-shadow(0 0 8px rgba(198, 156, 109, 0.6));
            }
        }

        .gradient-gold {
            animation: pulseGold 3s ease-in-out infinite;
        }

        .premium-card:hover .gradient-gold {
            animation: pulseGold 1.5s ease-in-out infinite;
        }

        /* Bounce Animation for Add Button */
        @keyframes bounceIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .btn-plus {
            animation: bounceIn 0.3s ease-out;
        }

        /* Shine Effect */
        .premium-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(198, 156, 109, 0.1), transparent);
            transition: left 0.5s ease;
            z-index: 10;
        }

        .premium-card:hover::before {
            left: 100%;
        }
        /* Reveal from left */
        .reveal-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-left.active {
            opacity: 1;
            transform: translateX(0);
        }

        /* Reveal from right */
        .reveal-right {
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-right.active {
            opacity: 1;
            transform: translateX(0);
        }

        /* Reveal with scale */
        .reveal-scale {
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-scale.active {
            opacity: 1;
            transform: scale(1);
        }

        /* Staggered reveal for children */
        .reveal-stagger > * {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-stagger.active > *:nth-child(1) { transition-delay: 0.1s; }
        .reveal-stagger.active > *:nth-child(2) { transition-delay: 0.2s; }
        .reveal-stagger.active > *:nth-child(3) { transition-delay: 0.3s; }
        .reveal-stagger.active > *:nth-child(4) { transition-delay: 0.4s; }

        .reveal-stagger.active > * {
            opacity: 1;
            transform: translateY(0);
        }

        /* Reveal for images */
        .reveal-image {
            opacity: 0;
            transform: scale(0.9);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal-image.active {
            opacity: 1;
            transform: scale(1);
        }

        /* Feature Card Animation */
        .feature-card {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card.active {
            opacity: 1;
            transform: translateY(0);
        }

        .feature-card:nth-child(2) { transition-delay: 0.15s; }
        .feature-card:nth-child(3) { transition-delay: 0.3s; }
        .feature-card:nth-child(4) { transition-delay: 0.45s; }

        /* Social Card Animation */
        .social-card {
            opacity: 0;
            transform: translateY(20px) scale(0.9);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .social-card.active {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .social-card:nth-child(1) { transition-delay: 0.1s; }
        .social-card:nth-child(2) { transition-delay: 0.2s; }
        .social-card:nth-child(3) { transition-delay: 0.3s; }
        .social-card:nth-child(4) { transition-delay: 0.4s; }

        /* Footer Animation */
        .footer-content {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .footer-content.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Float animation for decorative elements */
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .float-decor {
            animation: floatSlow 6s ease-in-out infinite;
        }

        /* Glow pulse for decorative elements */
        @keyframes glowPulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }

        .glow-pulse {
            animation: glowPulse 4s ease-in-out infinite;
        }

        /* Hide scrollbar for category filter */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Category section transition */
        .category-section {
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        .category-section.hidden {
            display: none;
        }

        .category-section.active {
            animation: categoryFadeIn 0.5s ease-out;
        }

        @keyframes categoryFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-premium-black text-cream min-h-screen">
    <!-- Hero Section with Slider -->
    <section class="relative h-[400px] md:h-[500px] lg:h-[600px] overflow-hidden">
        <!-- Background Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-premium-black/80 via-premium-black/50 to-premium-black z-10"></div>
        
        <!-- Sliding Images -->
        <div class="absolute inset-0">
            <!-- Slide 1 -->
            <div class="hero-slide absolute inset-0 w-full h-full">
                <img src="https://images.unsplash.com/photo-1497935586351-b67a49e012bf?w=1920&h=1080&fit=crop" 
                     alt="Premium Coffee" 
                     class="w-full h-full object-cover">
            </div>
            
            <!-- Slide 2 -->
            <div class="hero-slide absolute inset-0 w-full h-full">
                <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=1920&h=1080&fit=crop" 
                     alt="Coffee Beans" 
                     class="w-full h-full object-cover">
            </div>
            
            <!-- Slide 3 -->
            <div class="hero-slide absolute inset-0 w-full h-full">
                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1920&h=1080&fit=crop" 
                     alt="Coffee Cup" 
                     class="w-full h-full object-cover">
            </div>
        </div>
        
        <!-- Hero Content -->
        <div class="relative z-20 container mx-auto px-4 h-full flex items-center">
            <div class="max-w-3xl">
                <div class="inline-block mb-4 px-6 py-2 border border-premium-gold/50 rounded-full bg-premium-brown/30 backdrop-blur-sm">
                    <span class="text-premium-gold text-sm font-medium tracking-wider">☕ PREMIUM COFFEE EXPERIENCE</span>
                </div>
                
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-bold mb-4 md:mb-6 leading-tight">
                    <span class="gradient-gold">NgopiGo</span>
                    <br>
                    <span class="text-white text-2xl sm:text-3xl md:text-4xl lg:text-5xl">Taste the Excellence</span>
                </h1>

                <p class="text-base sm:text-lg md:text-xl text-white mb-6 md:mb-8 leading-relaxed max-w-2xl font-medium">
                    Nikmati setiap tegukan kopi premium pilihan dengan cita rasa autentik.
                    Dari biji kopi terbaik langsung ke cangkir Anda.
                </p>
                
                <div class="flex flex-wrap gap-3 sm:gap-4">
                    <a href="#menu"
                       onclick="smoothScrollTo('menu')"
                       class="group bg-premium-gold hover:bg-gold-light text-premium-black font-bold py-3 px-6 sm:py-4 sm:px-8 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-premium-gold/50 text-sm sm:text-base">
                        🛒 Pesan Sekarang
                        <span class="inline-block ml-2 group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                    <a href="#about"
                       onclick="smoothScrollTo('about')"
                       class="border-2 border-premium-gold/50 hover:border-premium-gold text-premium-gold font-bold py-3 px-6 sm:py-4 sm:px-8 rounded-full transition-all duration-300 hover:bg-premium-gold/10 text-sm sm:text-base">
                        ℹ️ Tentang Kami
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-2 sm:gap-4 md:gap-6 mt-8 md:mt-12 pt-6 md:pt-8 relative">
                    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#C69C6D]/50 to-transparent"></div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold gradient-gold">20+</div>
                        <div class="text-xs sm:text-sm text-white/90 mt-1 font-medium">Menu Premium</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold gradient-gold">100%</div>
                        <div class="text-xs sm:text-sm text-white/90 mt-1 font-medium">Biji Arabika</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold gradient-gold">24/7</div>
                        <div class="text-xs sm:text-sm text-white/90 mt-1 font-medium">Online Order</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20">
            <div class="w-6 h-10 border-2 border-premium-gold/50 rounded-full flex justify-center pt-2">
                <div class="w-1 h-3 bg-premium-gold rounded-full animate-bounce"></div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="py-12 md:py-16 lg:py-20 bg-gradient-to-b from-premium-black to-premium-brown">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-6 md:mb-10">
                <span class="text-premium-gold text-xs sm:text-sm font-medium tracking-wider uppercase">Our Premium Selection</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mt-4 mb-4 md:mb-6">
                    <span class="gradient-gold">Menu Favorit</span>
                </h2>
                <p class="text-white max-w-2xl mx-auto text-sm sm:text-lg font-medium">
                    Pilihan menu terbaik dari barista profesional kami
                </p>
            </div>

            <!-- Category Filter Buttons - Sticky -->
            <div class="sticky top-4 z-40 mb-8 md:mb-12">
                <div class="bg-premium-black/80 backdrop-blur-md rounded-full p-2 border border-premium-gold/20 shadow-xl">
                    <div class="flex gap-2 overflow-x-auto scrollbar-hide" id="categoryFilter">
                        <button type="button" 
                                data-category="all" 
                                class="category-btn flex-shrink-0 px-4 sm:px-6 py-2 sm:py-3 rounded-full text-sm sm:text-base font-bold transition-all duration-300 bg-premium-gold text-premium-black border border-premium-gold">
                            🍽️ Semua Menu
                        </button>
                        <button type="button" 
                                data-category="coffee" 
                                class="category-btn flex-shrink-0 px-4 sm:px-6 py-2 sm:py-3 rounded-full text-sm sm:text-base font-bold transition-all duration-300 bg-premium-black/50 text-premium-gold border border-premium-gold/30 hover:border-premium-gold">
                            ☕ Coffee
                        </button>
                        <button type="button" 
                                data-category="non-coffee" 
                                class="category-btn flex-shrink-0 px-4 sm:px-6 py-2 sm:py-3 rounded-full text-sm sm:text-base font-bold transition-all duration-300 bg-premium-black/50 text-premium-gold border border-premium-gold/30 hover:border-premium-gold">
                            🍵 Non Coffee
                        </button>
                        <button type="button" 
                                data-category="food" 
                                class="category-btn flex-shrink-0 px-4 sm:px-6 py-2 sm:py-3 rounded-full text-sm sm:text-base font-bold transition-all duration-300 bg-premium-black/50 text-premium-gold border border-premium-gold/30 hover:border-premium-gold">
                            🍛 Food
                        </button>
                        <button type="button" 
                                data-category="snack" 
                                class="category-btn flex-shrink-0 px-4 sm:px-6 py-2 sm:py-3 rounded-full text-sm sm:text-base font-bold transition-all duration-300 bg-premium-black/50 text-premium-gold border border-premium-gold/30 hover:border-premium-gold">
                            🍟 Snacks
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <main class="container mx-auto px-4 pb-32">
                <form action="{{ route('order.store') }}" method="POST" id="orderForm">
                    @csrf
                    <input type="hidden" name="table_number" value="{{ $tableNumber }}">

                    <!-- Menu Categories -->
                    @foreach(['coffee' => ['icon' => '☕', 'name' => 'Signature Coffee'], 'non-coffee' => ['icon' => '🍵', 'name' => 'Non Coffee'], 'food' => ['icon' => '🍛', 'name' => 'Premium Food'], 'snack' => ['icon' => '🍟', 'name' => 'Snacks & Bites']] as $categoryKey => $categoryData)
                        @if(isset($products[$categoryKey]) && $products[$categoryKey]->count() > 0)
                        <div class="mb-12 md:mb-16 reveal category-section" data-category="{{ $categoryKey }}">
                            <!-- Category Header -->
                            <div class="flex items-center gap-3 sm:gap-4 mb-6 sm:mb-8">
                                <div class="text-3xl sm:text-4xl">{{ $categoryData['icon'] }}</div>
                                <div>
                                    <h3 class="text-2xl sm:text-3xl font-bold text-premium-gold">{{ $categoryData['name'] }}</h3>
                                    <div class="w-16 sm:w-24 h-1 bg-premium-gold mt-2"></div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 auto-rows-fr">
                                @foreach($products[$categoryKey] as $product)
                                <div class="product-card premium-card gold-border-animate bg-premium-brown/50 rounded-2xl overflow-hidden border border-premium-gold/20 cursor-pointer relative group flex flex-col h-full"
                                     data-product-id="{{ $product->id }}"
                                     data-product-name="{{ $product->name }}"
                                     data-product-price="{{ $product->price }}"
                                     data-category="{{ $categoryKey }}">
                                    <!-- Product Image Container - Fixed Square -->
                                    @if($product->image)
                                    <div class="relative w-full aspect-square bg-gradient-to-br from-[#2E1F1A] to-[#1a120f] overflow-hidden">
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             alt="{{ $product->name }}"
                                             class="absolute inset-0 w-full h-full object-cover product-image transform group-hover:scale-105 transition-transform duration-500">
                                        <!-- Subtle shine effect -->
                                        <div class="absolute inset-0 bg-gradient-to-tr from-white/5 via-transparent to-white/10 pointer-events-none"></div>
                                    </div>
                                    @else
                                    <div class="w-full aspect-square bg-gradient-to-br from-[#2E1F1A] to-[#1a120f] flex items-center justify-center product-image">
                                        <span class="text-5xl sm:text-6xl opacity-50">📷</span>
                                    </div>
                                    @endif

                                    <!-- Product Content -->
                                    <div class="p-3 sm:p-4 flex-1 flex flex-col justify-between">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm sm:text-base md:text-lg font-bold text-white mb-1 line-clamp-2 leading-tight">{{ $product->name }}</h4>
                                                <p class="text-[10px] sm:text-xs text-white/80 line-clamp-2 font-medium hidden sm:block">{{ $product->description }}</p>
                                            </div>
                                        </div>

                                        <div class="relative flex items-center justify-between mt-3 pt-3 border-t border-premium-gold/20">
                                            <span class="text-sm sm:text-base md:text-lg font-bold gradient-gold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                            <div class="flex items-center gap-1 sm:gap-1.5">
                                                <button type="button"
                                                        class="btn-minus w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-premium-black/50 hover:bg-premium-gold/20 border border-premium-gold/30 flex items-center justify-center font-bold text-premium-gold transition-all text-sm sm:text-base flex-shrink-0"
                                                        onclick="event.stopPropagation(); updateQuantity({{ $product->id }}, -1)">
                                                    −
                                                </button>
                                                <input type="number"
                                                       name="items[{{ $product->id }}][quantity]"
                                                       id="qty-{{ $product->id }}"
                                                       class="qty-input w-10 sm:w-12 text-center bg-premium-black/50 border border-premium-gold/30 rounded-lg py-1 font-bold text-premium-gold focus:border-premium-gold focus:outline-none text-xs sm:text-sm flex-shrink-0"
                                                       value="0"
                                                       min="0"
                                                       max="99"
                                                       onclick="event.stopPropagation()"
                                                       onchange="updateQuantity({{ $product->id }}, 0)">
                                                <input type="hidden" name="items[{{ $product->id }}][product_id]" value="{{ $product->id }}">
                                                <button type="button"
                                                        class="btn-plus w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-premium-gold hover:bg-gold-light flex items-center justify-center font-bold text-premium-black transition-all text-sm sm:text-base flex-shrink-0"
                                                        onclick="event.stopPropagation(); updateQuantity({{ $product->id }}, 1)">
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endforeach
                </form>

                <!-- Floating Cart Summary -->
                <div id="cartSummary" class="fixed bottom-0 left-0 right-0 bg-gradient-to-r from-[#2E1F1A] via-[#1a120f] to-[#2E1F1A] border-t-4 border-[#C69C6D] shadow-2xl p-3 sm:p-4 md:p-6 transform translate-y-full transition-transform duration-300 z-50">
                    <div class="container mx-auto">
                        <div class="flex items-center justify-between gap-2 sm:gap-4">
                            <div class="flex items-center gap-3 sm:gap-6 md:gap-8">
                                <div>
                                    <div class="flex items-center gap-1 sm:gap-2 mb-1 sm:mb-2">
                                        <span class="text-xl sm:text-2xl">🛒</span>
                                        <p class="text-[#C69C6D] text-xs sm:text-sm font-bold uppercase tracking-wider">Total Pesanan</p>
                                    </div>
                                    <p class="text-2xl sm:text-3xl md:text-4xl font-bold bg-gradient-to-r from-[#C69C6D] to-[#F5DEB3] bg-clip-text text-transparent" id="cartTotal">Rp 0</p>
                                </div>
                                <div class="h-10 sm:h-16 w-px bg-gradient-to-b from-[#C69C6D]/20 via-[#C69C6D] to-[#C69C6D]/20 hidden sm:block"></div>
                                <div class="text-center hidden sm:block">
                                    <p class="text-white text-xs sm:text-sm mb-1 font-bold uppercase tracking-wider">Total Item</p>
                                    <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-white" id="cartCount">0</p>
                                </div>
                            </div>
                            <button type="button"
                                    onclick="showCheckoutModal()"
                                    class="bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] hover:from-[#D4AF7A] hover:to-[#C69C6D] text-[#121212] font-bold py-2 px-4 sm:py-3 sm:px-6 md:py-4 md:px-10 rounded-full shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center gap-2 sm:gap-3 text-sm sm:text-base">
                                    <span class="text-lg sm:text-2xl">🛒</span>
                                    <span class="hidden sm:inline text-lg font-bold">Lanjut ke Checkout</span>
                                    <span class="text-xl">→</span>
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-12 md:py-16 lg:py-24 bg-gradient-to-b from-premium-brown to-premium-black relative overflow-hidden reveal">
        <!-- Background Decoration -->
        <div class="absolute top-0 left-0 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-premium-gold/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-premium-gold/5 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-4 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-8 sm:mb-12 md:mb-16">
                <span class="text-premium-gold text-xs sm:text-sm font-medium tracking-wider uppercase">Our Story</span>
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mt-4 mb-4 sm:mb-6 text-white">
                    Crafted with <span class="gradient-gold">Passion</span>
                </h2>
                <div class="w-16 sm:w-24 h-1 bg-gradient-to-r from-transparent via-premium-gold to-transparent mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-10 lg:gap-20 items-center">
                <!-- Left Content - Story -->
                <div class="reveal-left">
                    <div class="relative">
                        <div class="absolute -left-2 -top-2 sm:-left-4 sm:-top-4 w-12 sm:w-20 h-12 sm:h-20 border-l-2 sm:border-l-4 border-t-2 sm:border-t-4 border-premium-gold/30 rounded-tl-xl sm:rounded-tl-3xl"></div>
                        <div class="absolute -right-2 -bottom-2 sm:-right-4 sm:-bottom-4 w-12 sm:w-20 h-12 sm:h-20 border-r-2 sm:border-r-4 border-b-2 sm:border-b-4 border-premium-gold/30 rounded-br-xl sm:rounded-br-3xl"></div>

                        <div class="bg-premium-black/40 backdrop-blur-sm p-4 sm:p-6 md:p-8 rounded-2xl sm:rounded-3xl border border-premium-gold/20">
                            <p class="text-white text-base sm:text-lg leading-relaxed mb-4 sm:mb-6 font-medium">
                                <span class="text-premium-gold font-bold">NgopiGo</span> menghadirkan pengalaman kopi premium dengan biji kopi pilihan dari seluruh nusantara. 
                                Setiap cangkir dibuat dengan hati-hati oleh barista profesional kami.
                            </p>
                            <p class="text-white text-base leading-relaxed mb-6 font-medium">
                                Kami berkomitmen untuk menyajikan kualitas terbaik, dari biji kopi yang dipetik dari petani lokal hingga menjadi secangkir kopi yang sempurna di tangan Anda.
                            </p>
                            
                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-2 sm:gap-4 mt-6 sm:mt-8 pt-4 sm:pt-8 relative">
                                <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#C69C6D]/50 to-transparent"></div>
                                <div class="text-center">
                                    <div class="text-2xl sm:text-3xl font-bold gradient-gold">20+</div>
                                    <div class="text-xs sm:text-sm text-white/90 mt-1 font-medium">Menu Premium</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl sm:text-3xl font-bold gradient-gold">100%</div>
                                    <div class="text-xs sm:text-sm text-white/90 mt-1 font-medium">Arabika</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl sm:text-3xl font-bold gradient-gold">24/7</div>
                                    <div class="text-xs sm:text-sm text-white/90 mt-1 font-medium">Online</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feature Cards -->
                    <div class="grid grid-cols-2 gap-3 sm:gap-4 md:gap-6 mt-6 sm:mt-8 reveal-stagger">
                        <div class="feature-card group relative bg-gradient-to-br from-premium-black/80 to-premium-black/40 p-4 sm:p-6 rounded-2xl border border-premium-gold/20 hover:border-premium-gold/40 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-[#C69C6D]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <div class="text-3xl sm:text-4xl mb-2 sm:mb-3">⭐</div>
                                <div class="text-lg sm:text-xl font-bold gradient-gold mb-1">Premium Quality</div>
                                <div class="text-xs sm:text-sm text-white/80 font-medium">Kualitas terbaik</div>
                            </div>
                        </div>
                        <div class="feature-card group relative bg-gradient-to-br from-premium-black/80 to-premium-black/40 p-4 sm:p-6 rounded-2xl border border-premium-gold/20 hover:border-premium-gold/40 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-[#C69C6D]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <div class="text-3xl sm:text-4xl mb-2 sm:mb-3">👨‍🍳</div>
                                <div class="text-lg sm:text-xl font-bold gradient-gold mb-1">Pro Barista</div>
                                <div class="text-xs sm:text-sm text-white/80 font-medium">Ahli kopi</div>
                            </div>
                        </div>
                        <div class="feature-card group relative bg-gradient-to-br from-premium-black/80 to-premium-black/40 p-4 sm:p-6 rounded-2xl border border-premium-gold/20 hover:border-premium-gold/40 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-[#C69C6D]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <div class="text-3xl sm:text-4xl mb-2 sm:mb-3">🌿</div>
                                <div class="text-lg sm:text-xl font-bold gradient-gold mb-1">Fresh</div>
                                <div class="text-xs sm:text-sm text-white/80 font-medium">Bahan segar</div>
                            </div>
                        </div>
                        <div class="feature-card group relative bg-gradient-to-br from-premium-black/80 to-premium-black/40 p-4 sm:p-6 rounded-2xl border border-premium-gold/20 hover:border-premium-gold/40 transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-[#C69C6D]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <div class="text-3xl sm:text-4xl mb-2 sm:mb-3">⚡</div>
                                <div class="text-lg sm:text-xl font-bold gradient-gold mb-1">Fast</div>
                                <div class="text-xs sm:text-sm text-white/80 font-medium">Pelayanan cepat</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Images Grid -->
                <div class="reveal-right">
                    <div class="grid grid-cols-2 gap-3 sm:gap-4">
                        <div class="space-y-3 sm:space-y-4">
                            <div class="reveal-image relative group overflow-hidden rounded-xl sm:rounded-2xl border-2 border-premium-gold/30">
                                <img src="https://images.unsplash.com/photo-1497935586351-b67a49e012bf?w=400&h=500&fit=crop"
                                     alt="Premium Coffee"
                                     class="w-full h-32 sm:h-48 md:h-64 object-cover transform group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-premium-brown/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="reveal-image relative group overflow-hidden rounded-xl sm:rounded-2xl border-2 border-premium-gold/30">
                                <img src="https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=400&h=300&fit=crop"
                                     alt="Coffee Beans"
                                     class="w-full h-24 sm:h-32 md:h-40 object-cover transform group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-premium-brown/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        </div>
                        <div class="space-y-3 sm:space-y-4 pt-6 sm:pt-8 md:pt-12">
                            <div class="reveal-image relative group overflow-hidden rounded-xl sm:rounded-2xl border-2 border-premium-gold/30">
                                <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=400&h=300&fit=crop"
                                     alt="Coffee Art"
                                     class="w-full h-24 sm:h-32 md:h-40 object-cover transform group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-premium-brown/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="reveal-image relative group overflow-hidden rounded-xl sm:rounded-2xl border-2 border-premium-gold/30">
                                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400&h=500&fit=crop"
                                     alt="Coffee Cup"
                                     class="w-full h-32 sm:h-48 md:h-64 object-cover transform group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-premium-brown/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Social Media Section -->
            <div class="mt-12 sm:mt-16 md:mt-20 text-center reveal-stagger">
                <h3 class="text-xl sm:text-2xl font-bold text-white mb-2 reveal">Follow Us</h3>
                <p class="text-white/70 mb-6 sm:mb-8 font-medium text-sm sm:text-base reveal">Ikuti kami di media sosial untuk update terbaru dan promo spesial!</p>

                <div class="flex justify-center gap-3 sm:gap-4 flex-wrap">
                    <!-- Instagram -->
                    <a href="https://instagram.com/ngopigo" target="_blank"
                       class="social-card group flex items-center gap-2 sm:gap-3 bg-gradient-to-r from-purple-900/50 to-pink-900/50 hover:from-purple-800/70 hover:to-pink-800/70 px-4 sm:px-6 py-3 sm:py-4 rounded-xl sm:rounded-2xl border border-premium-gold/30 hover:border-premium-gold transition-all duration-300 transform hover:-translate-y-1">
                        <div class="text-2xl sm:text-3xl">📷</div>
                        <div class="text-left hidden sm:block">
                            <div class="text-white font-bold">Instagram</div>
                            <div class="text-premium-gold text-sm">@ngopigo</div>
                        </div>
                    </a>

                    <!-- Facebook -->
                    <a href="https://facebook.com/ngopigo" target="_blank"
                       class="social-card group flex items-center gap-2 sm:gap-3 bg-gradient-to-r from-blue-900/50 to-blue-800/50 hover:from-blue-800/70 hover:to-blue-700/70 px-4 sm:px-6 py-3 sm:py-4 rounded-xl sm:rounded-2xl border border-premium-gold/30 hover:border-premium-gold transition-all duration-300 transform hover:-translate-y-1">
                        <div class="text-2xl sm:text-3xl">📘</div>
                        <div class="text-left hidden sm:block">
                            <div class="text-white font-bold">Facebook</div>
                            <div class="text-premium-gold text-sm">NgopiGo</div>
                        </div>
                    </a>

                    <!-- TikTok -->
                    <a href="https://tiktok.com/@ngopigo" target="_blank"
                       class="social-card group flex items-center gap-2 sm:gap-3 bg-gradient-to-r from-gray-900/50 to-gray-800/50 hover:from-gray-800/70 hover:to-gray-700/70 px-4 sm:px-6 py-3 sm:py-4 rounded-xl sm:rounded-2xl border border-premium-gold/30 hover:border-premium-gold transition-all duration-300 transform hover:-translate-y-1">
                        <div class="text-2xl sm:text-3xl">🎵</div>
                        <div class="text-left hidden sm:block">
                            <div class="text-white font-bold">TikTok</div>
                            <div class="text-premium-gold text-sm">@ngopigo</div>
                        </div>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/6281234567890" target="_blank"
                       class="social-card group flex items-center gap-2 sm:gap-3 bg-gradient-to-r from-green-900/50 to-green-800/50 hover:from-green-800/70 hover:to-green-700/70 px-4 sm:px-6 py-3 sm:py-4 rounded-xl sm:rounded-2xl border border-premium-gold/30 hover:border-premium-gold transition-all duration-300 transform hover:-translate-y-1">
                        <div class="text-2xl sm:text-3xl">💬</div>
                        <div class="text-left hidden sm:block">
                            <div class="text-white font-bold">WhatsApp</div>
                            <div class="text-premium-gold text-sm">+62 812-3456-7890</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-premium-black py-8 sm:py-12 md:py-16 border-t border-premium-gold/20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 sm:gap-10 md:gap-12 mb-8 sm:mb-12">
                <!-- Brand Info -->
                <div class="footer-content text-center sm:text-left">
                    <h3 class="text-2xl sm:text-3xl font-bold gradient-gold mb-3 sm:mb-4">NgopiGo</h3>
                    <p class="text-white/80 mb-3 sm:mb-4 font-medium text-sm sm:text-base">Premium Coffee Experience</p>
                    <p class="text-white/60 text-xs sm:text-sm font-medium">Menghadirkan kenikmatan kopi terbaik sejak 2024</p>
                </div>

                <!-- Contact Info -->
                <div class="footer-content text-center">
                    <h4 class="text-base sm:text-lg font-bold text-white mb-3 sm:mb-4">Kontak Kami</h4>
                    <div class="space-y-2">
                        <p class="text-white/70 text-xs sm:text-sm font-medium">📍 Jakarta, Indonesia</p>
                        <p class="text-white/70 text-xs sm:text-sm font-medium">📧 hello@ngopigo.com</p>
                        <p class="text-white/70 text-xs sm:text-sm font-medium">📱 +62 812-3456-7890</p>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="footer-content text-center sm:text-right">
                    <h4 class="text-base sm:text-lg font-bold text-white mb-3 sm:mb-4">Follow Us</h4>
                    <div class="flex justify-center sm:justify-end gap-3 sm:gap-4">
                        <a href="https://instagram.com/ngopigo" target="_blank"
                           class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center text-white text-lg sm:text-xl hover:scale-110 transition-transform shadow-lg">
                            📷
                        </a>
                        <a href="https://facebook.com/ngopigo" target="_blank"
                           class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white text-lg sm:text-xl hover:scale-110 transition-transform shadow-lg">
                            📘
                        </a>
                        <a href="https://tiktok.com/@ngopigo" target="_blank"
                           class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-gray-700 to-black flex items-center justify-center text-white text-lg sm:text-xl hover:scale-110 transition-transform shadow-lg">
                            🎵
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank"
                           class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center text-white text-lg sm:text-xl hover:scale-110 transition-transform shadow-lg">
                            💬
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-premium-gold/20 pt-6 sm:pt-8">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-3 sm:gap-4">
                    <p class="text-white/60 text-xs sm:text-sm font-medium text-center sm:text-left">
                        © {{ date('Y') }} NgopiGo. All rights reserved.
                    </p>
                    <div class="flex gap-4 sm:gap-6">
                        <a href="#" class="text-white/60 hover:text-premium-gold text-xs sm:text-sm font-medium transition-colors">Privacy Policy</a>
                        <a href="#" class="text-white/60 hover:text-premium-gold text-xs sm:text-sm font-medium transition-colors">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Checkout Modal -->
    <div id="checkoutModal" class="fixed inset-0 bg-black/90 backdrop-blur-md z-50 hidden flex items-center justify-center p-2 sm:p-4 overflow-y-auto">
        <div class="bg-gradient-to-br from-[#2E1F1A] to-[#1a120f] rounded-2xl sm:rounded-3xl shadow-2xl w-full max-w-xl sm:max-w-2xl my-4 sm:my-8 max-h-[95vh] overflow-y-auto border-2 border-[#C69C6D]/40">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] text-[#121212] px-4 sm:px-6 md:px-8 py-4 sm:py-5 md:py-6 rounded-t-2xl sm:rounded-t-3xl flex items-center justify-between sticky top-0 z-10">
                <h2 class="text-lg sm:text-xl md:text-2xl font-bold flex items-center gap-2 sm:gap-3">
                    <span class="text-2xl sm:text-3xl">📝</span>
                    <span>Checkout Pesanan</span>
                </h2>
                <button type="button" onclick="hideCheckoutModal()" class="text-[#121212] hover:text-white text-2xl sm:text-3xl font-bold transition-colors w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-full hover:bg-white/20">
                    &times;
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 sm:p-6 md:p-8">
                <form action="{{ route('order.store') }}" method="POST" id="checkoutForm">
                    @csrf
                    <input type="hidden" name="table_number" value="{{ $tableNumber }}">

                    <!-- Order Summary -->
                    <div class="bg-[#121212]/80 rounded-xl sm:rounded-2xl p-4 sm:p-6 mb-4 sm:mb-6 border-2 border-[#C69C6D]/30">
                        <h3 class="font-bold text-[#C69C6D] mb-3 sm:mb-4 text-base sm:text-lg flex items-center gap-2">
                            <span class="text-xl sm:text-2xl">🛒</span>
                            <span>Ringkasan Pesanan</span>
                        </h3>
                        <div id="checkoutItems" class="space-y-2 sm:space-y-3">
                            <!-- Items populated by JS -->
                        </div>
                        <div class="relative mt-4 sm:mt-6 pt-4 sm:pt-6">
                            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#C69C6D]/60 to-transparent"></div>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-white text-base sm:text-lg tracking-wide">Total Bayar</span>
                                <span class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-[#C69C6D] to-[#F5DEB3] bg-clip-text text-transparent tracking-tight" id="checkoutTotal">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="mb-4 sm:mb-6">
                        <h3 class="font-bold text-white mb-3 sm:mb-4 text-base sm:text-lg flex items-center gap-2">
                            <span class="text-xl sm:text-2xl">👤</span>
                            <span>Informasi Customer</span>
                        </h3>
                        <div class="space-y-3 sm:space-y-4">
                            <div>
                                <label for="customer_name" class="block text-xs sm:text-sm font-medium text-gray-300 mb-1 sm:mb-2">Nama Lengkap <span class="text-[#C69C6D]">*</span></label>
                                <input type="text"
                                       name="customer_name"
                                       id="customer_name"
                                       required
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-[#121212]/60 border-2 border-[#C69C6D]/30 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition text-white placeholder-gray-500 text-sm sm:text-base"
                                       placeholder="Masukkan nama Anda">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <div>
                                    <label for="phone" class="block text-xs sm:text-sm font-medium text-gray-300 mb-1 sm:mb-2">Nomor WhatsApp <span class="text-[#C69C6D]">*</span></label>
                                    <input type="tel"
                                           name="phone"
                                           id="phone"
                                           required
                                           class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-[#121212]/60 border-2 border-[#C69C6D]/30 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition text-white placeholder-gray-500 text-sm sm:text-base"
                                           placeholder="08123456789">
                                </div>
                                <div>
                                    <label for="email" class="block text-xs sm:text-sm font-medium text-gray-300 mb-1 sm:mb-2">Email</label>
                                    <input type="email"
                                           name="email"
                                           id="email"
                                           class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-[#121212]/60 border-2 border-[#C69C6D]/30 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition text-white placeholder-gray-500 text-sm sm:text-base"
                                           placeholder="email@contoh.com">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="mb-4 sm:mb-6">
                        <h3 class="font-bold text-white mb-3 sm:mb-4 text-base sm:text-lg flex items-center gap-2">
                            <span class="text-xl sm:text-2xl">📝</span>
                            <span>Catatan Pesanan</span>
                        </h3>
                        <textarea name="notes"
                                  id="notes"
                                  rows="2 sm:rows-3"
                                  class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-[#121212]/60 border-2 border-[#C69C6D]/30 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition text-white placeholder-gray-500 text-sm sm:text-base"
                                  placeholder="Contoh: Jangan terlalu manis, kurang es batu, dll"></textarea>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-4 sm:mb-6 md:mb-8">
                        <h3 class="font-bold text-white mb-3 sm:mb-4 text-base sm:text-lg flex items-center gap-2">
                            <span class="text-xl sm:text-2xl">💳</span>
                            <span>Metode Pembayaran</span>
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <label class="relative cursor-pointer">
                                <input type="radio"
                                       name="payment_method"
                                       value="cod"
                                       checked
                                       class="peer sr-only">
                                <div class="bg-[#121212]/60 border-2 border-[#C69C6D]/30 rounded-xl sm:rounded-2xl p-4 sm:p-5 peer-checked:border-[#C69C6D] peer-checked:bg-[#C69C6D]/10 transition-all hover:border-[#C69C6D]/50">
                                    <div class="text-2xl sm:text-3xl mb-1 sm:mb-2">💵</div>
                                    <div class="font-bold text-white text-sm sm:text-base">Bayar di Tempat</div>
                                    <div class="text-xs sm:text-sm text-gray-400">COD - Cash on Delivery</div>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio"
                                       name="payment_method"
                                       value="online"
                                       class="peer sr-only">
                                <div class="bg-[#121212]/60 border-2 border-[#C69C6D]/30 rounded-xl sm:rounded-2xl p-4 sm:p-5 peer-checked:border-[#C69C6D] peer-checked:bg-[#C69C6D]/10 transition-all hover:border-[#C69C6D]/50">
                                    <div class="text-2xl sm:text-3xl mb-1 sm:mb-2">💳</div>
                                    <div class="font-bold text-white text-sm sm:text-base">Bayar Online</div>
                                    <div class="text-xs sm:text-sm text-gray-400">Transfer Bank / E-Wallet</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-2 sm:gap-4">
                        <button type="button"
                                onclick="hideCheckoutModal()"
                                class="px-4 sm:px-6 py-2 sm:py-4 border-2 border-[#C69C6D]/30 text-gray-300 font-bold rounded-xl hover:bg-[#C69C6D]/10 hover:border-[#C69C6D] transition text-center text-sm sm:text-base">
                            Kembali
                        </button>
                        <button type="submit"
                                class="flex-1 bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] hover:from-[#D4AF7A] hover:to-[#C69C6D] text-[#121212] font-bold py-2 sm:py-3 md:py-4 px-4 sm:px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center gap-2 text-sm sm:text-base">
                            <span class="text-xl sm:text-2xl">✅</span>
                            <span>Buat Pesanan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const products = @json($products->flatten());
        let cart = {};

        // Smooth scroll function
        function smoothScrollTo(targetId) {
            const element = document.getElementById(targetId);
            if (element) {
                element.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        // Scroll reveal animation
        function revealOnScroll() {
            const revealClasses = ['.reveal', '.reveal-left', '.reveal-right', '.reveal-scale', '.reveal-stagger', '.reveal-image', '.feature-card', '.social-card', '.footer-content'];

            revealClasses.forEach(selector => {
                document.querySelectorAll(selector).forEach(element => {
                    if (element.classList.contains('active')) return;

                    const windowHeight = window.innerHeight;
                    const elementTop = element.getBoundingClientRect().top;
                    const revealPoint = 150;

                    if (elementTop < windowHeight - revealPoint) {
                        element.classList.add('active');
                    }
                });
            });
        }

        // Add ripple effect to product cards
        function createRipple(event, element) {
            const circle = document.createElement('span');
            const diameter = Math.max(element.clientWidth, element.clientHeight);
            const radius = diameter / 2;

            circle.style.width = circle.style.height = diameter + 'px';
            circle.style.left = (event.clientX - element.getBoundingClientRect().left - radius) + 'px';
            circle.style.top = (event.clientY - element.getBoundingClientRect().top - radius) + 'px';
            circle.classList.add('ripple');

            const ripple = element.querySelector('.ripple');
            if (ripple) ripple.remove();

            element.appendChild(circle);
        }

        // Track mouse position for glow effect
        document.querySelectorAll('.premium-card').forEach(card => {
            card.addEventListener('mousemove', function(e) {
                const rect = card.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                card.style.setProperty('--mouse-x', x + '%');
                card.style.setProperty('--mouse-y', y + '%');
            });
        });

        // Initialize scroll reveal
        window.addEventListener('scroll', revealOnScroll);
        window.addEventListener('load', revealOnScroll);

        function updateQuantity(productId, change) {
            const input = document.getElementById(`qty-${productId}`);
            let value = parseInt(input.value) || 0;

            if (change !== 0) {
                value = Math.max(0, Math.min(99, value + change));
            }

            input.value = value;
            cart[productId] = value;

            updateCartSummary();
        }

        function updateCartSummary() {
            let total = 0;
            let count = 0;

            for (const [productId, qty] of Object.entries(cart)) {
                if (qty > 0) {
                    const product = products.find(p => p.id == productId);
                    if (product) {
                        total += product.price * qty;
                        count += qty;
                    }
                }
            }

            document.getElementById('cartTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('cartCount').textContent = count;

            const cartSummary = document.getElementById('cartSummary');
            if (count > 0) {
                cartSummary.classList.remove('translate-y-full');
            } else {
                cartSummary.classList.add('translate-y-full');
            }
        }

        function showCheckoutModal() {
            let total = 0;
            let itemsHtml = '';

            for (const [productId, qty] of Object.entries(cart)) {
                if (qty > 0) {
                    const product = products.find(p => p.id == productId);
                    if (product) {
                        const subtotal = product.price * qty;
                        total += subtotal;
                        itemsHtml += `
                            <div class="flex justify-between items-center p-3 sm:p-4 bg-gradient-to-r from-[#1a120f] to-[#121212] rounded-xl sm:rounded-2xl border border-[#C69C6D]/30 shadow-lg">
                                <div class="flex items-center gap-2 sm:gap-3">
                                    <span class="bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] text-[#121212] font-bold text-sm px-3 sm:px-4 py-1 sm:py-2 rounded-full shadow-md">${qty}x</span>
                                    <span class="text-white font-semibold text-sm sm:text-base">${product.name}</span>
                                </div>
                                <span class="text-[#C69C6D] font-bold text-sm sm:text-base">Rp ${subtotal.toLocaleString('id-ID')}</span>
                            </div>
                        `;
                        // Add hidden input for form
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = `items[${productId}][product_id]`;
                        hiddenInput.value = productId;
                        document.getElementById('checkoutForm').appendChild(hiddenInput);

                        const qtyInput = document.createElement('input');
                        qtyInput.type = 'hidden';
                        qtyInput.name = `items[${productId}][quantity]`;
                        qtyInput.value = qty;
                        document.getElementById('checkoutForm').appendChild(qtyInput);
                    }
                }
            }

            document.getElementById('checkoutItems').innerHTML = itemsHtml;
            document.getElementById('checkoutTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('checkoutModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hideCheckoutModal() {
            document.getElementById('checkoutModal').classList.add('hidden');
            document.body.style.overflow = '';

            // Remove hidden inputs from checkout form
            const hiddenInputs = document.querySelectorAll('#checkoutForm input[type="hidden"][name^="items"]');
            hiddenInputs.forEach(input => input.remove());
        }

        // Add click effect to product cards with ripple
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (!e.target.classList.contains('btn-minus') &&
                    !e.target.classList.contains('btn-plus') &&
                    !e.target.classList.contains('qty-input') &&
                    e.target.tagName !== 'INPUT') {
                    const productId = this.dataset.productId;
                    createRipple(e, this);
                    updateQuantity(productId, 1);
                }
            });
        });

        // Close modal on outside click
        document.getElementById('checkoutModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideCheckoutModal();
            }
        });

        // Category Filter Functionality
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const category = this.dataset.category;
                
                // Update active button
                document.querySelectorAll('.category-btn').forEach(b => {
                    b.classList.remove('bg-premium-gold', 'text-premium-black', 'border-premium-gold');
                    b.classList.add('bg-premium-black/50', 'text-premium-gold', 'border-premium-gold/30');
                });
                this.classList.remove('bg-premium-black/50', 'text-premium-gold', 'border-premium-gold/30');
                this.classList.add('bg-premium-gold', 'text-premium-black', 'border-premium-gold');
                
                // Filter products
                document.querySelectorAll('.category-section').forEach(section => {
                    if (category === 'all' || section.dataset.category === category) {
                        section.classList.remove('hidden');
                        // Trigger reveal animation
                        setTimeout(() => {
                            section.classList.add('active');
                        }, 100);
                    } else {
                        section.classList.add('hidden');
                        section.classList.remove('active');
                    }
                });
                
                // Update URL hash
                if (category !== 'all') {
                    history.pushState(null, null, `#category-${category}`);
                } else {
                    history.pushState(null, null, '#menu');
                }
            });
        });

        // Handle hash on page load
        window.addEventListener('DOMContentLoaded', () => {
            const hash = window.location.hash;
            if (hash.startsWith('#category-')) {
                const category = hash.replace('#category-', '');
                const btn = document.querySelector(`.category-btn[data-category="${category}"]`);
                if (btn) btn.click();
            }
        });
    </script>
</body>
</html>

