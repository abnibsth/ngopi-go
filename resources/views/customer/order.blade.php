<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NgopiGo - Premium Coffee & Bites</title>
            <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Custom Premium Colors */
        :root {
            --black: #0e0c0a;
            --dark-brown: #1e1410;
            --mid-brown: #2a1c16;
            --gold: #b8924a;
            --gold-light: #d4af7a;
            --gold-pale: #e8d5b0;
            --cream: #f4ede3;
            --warm-white: #faf7f2;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--black);
            color: var(--cream);
        }

        h1, h2, h3, .font-serif {
            font-family: 'Playfair Display', serif;
        }
        
        .bg-premium-black { background-color: var(--black); }
        .bg-premium-brown { background-color: var(--dark-brown); }
        .bg-mid-brown { background-color: var(--mid-brown); }
        .bg-premium-gold { background-color: var(--gold); }
        .text-premium-gold { color: var(--gold); }
        .text-gold-light { color: var(--gold-light); }
        .text-gold-pale { color: var(--gold-pale); }
        .border-premium-gold { border-color: var(--gold); }
        .border-gold-dim { border-color: rgba(184,146,74,0.25); }
        
        /* Hero Fade Slider */
        @keyframes heroFade {
            0%   { opacity: 0; transform: scale(1.05); }
            8%   { opacity: 1; transform: scale(1); }
            38%  { opacity: 1; transform: scale(1.02); }
            44%  { opacity: 0; transform: scale(1.04); }
            100% { opacity: 0; }
        }
        .hero-slide {
            animation: heroFade 18s ease-in-out infinite;
            position: absolute;
            inset: 0;
        }
        .hero-slide:nth-child(2) { animation-delay: 6s; }
        .hero-slide:nth-child(3) { animation-delay: 12s; }
        
        /* Gradient Text */
        .gradient-gold {
            background: linear-gradient(120deg, #b8924a 0%, #e8d5b0 45%, #c4a265 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Premium Card */
        .premium-card {
            transition: transform 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                        box-shadow 0.35s ease,
                        border-color 0.3s ease;
        }
        .premium-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 36px rgba(184,146,74,0.18), 0 4px 12px rgba(0,0,0,0.4);
            border-color: rgba(184,146,74,0.5);
        }
        
        /* Subtle inner glow on hover */
        .gold-border-animate {
            position: relative;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--dark-brown); }
        ::-webkit-scrollbar-thumb { background: rgba(184,146,74,0.5); border-radius: 3px; }
        html { scroll-behavior: smooth; }

        /* Scroll Reveal */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s ease, transform 0.7s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .reveal.active { opacity: 1; transform: translateY(0); }

        /* Product Card */
        .product-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            opacity: 0;
            transform: translateY(22px);
            animation: cardIn 0.55s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        }
        .product-card:nth-child(1) { animation-delay: 0.06s; }
        .product-card:nth-child(2) { animation-delay: 0.12s; }
        .product-card:nth-child(3) { animation-delay: 0.18s; }
        .product-card:nth-child(4) { animation-delay: 0.24s; }
        .product-card:nth-child(5) { animation-delay: 0.30s; }
        .product-card:nth-child(6) { animation-delay: 0.36s; }
        @keyframes cardIn { to { opacity: 1; transform: translateY(0); } }
        .product-card .aspect-square { flex-shrink: 0; }
        .product-card > div:last-child { flex: 1; }

        /* Product Image */
        .product-image { transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .premium-card:hover .product-image { transform: scale(1.07); }

        /* Card - relative + overflow */
        .premium-card { position: relative; overflow: hidden; }

        /* Ripple */
        .ripple {
            position: absolute; border-radius: 50%;
            background: radial-gradient(circle, rgba(184,146,74,0.35) 0%, transparent 70%);
            transform: scale(0);
            animation: rippleOut 0.55s ease-out;
            pointer-events: none;
        }
        @keyframes rippleOut { to { transform: scale(4); opacity: 0; } }

        /* Shimmer on hover */
        .premium-card::before {
            content: ''; position: absolute;
            top: 0; left: -100%; width: 60%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.06), transparent);
            transition: left 0.6s ease; z-index: 10;
        }
        .premium-card:hover::before { left: 150%; }
        /* Reveal variants */
        .reveal-left { opacity:0; transform:translateX(-36px); transition: opacity .7s ease, transform .7s cubic-bezier(0.23,1,0.32,1); }
        .reveal-left.active { opacity:1; transform:translateX(0); }
        .reveal-right { opacity:0; transform:translateX(36px); transition: opacity .7s ease, transform .7s cubic-bezier(0.23,1,0.32,1); }
        .reveal-right.active { opacity:1; transform:translateX(0); }
        .reveal-scale { opacity:0; transform:scale(0.88); transition: opacity .6s ease, transform .6s cubic-bezier(0.23,1,0.32,1); }
        .reveal-scale.active { opacity:1; transform:scale(1); }
        .reveal-image { opacity:0; transform:scale(0.93); transition: opacity .7s ease, transform .7s cubic-bezier(0.23,1,0.32,1); }
        .reveal-image.active { opacity:1; transform:scale(1); }

        /* Stagger children */
        .reveal-stagger > * { opacity:0; transform:translateY(18px); transition: opacity .5s ease, transform .5s cubic-bezier(0.23,1,0.32,1); }
        .reveal-stagger.active > * { opacity:1; transform:translateY(0); }
        .reveal-stagger.active > *:nth-child(1) { transition-delay:.08s; }
        .reveal-stagger.active > *:nth-child(2) { transition-delay:.16s; }
        .reveal-stagger.active > *:nth-child(3) { transition-delay:.24s; }
        .reveal-stagger.active > *:nth-child(4) { transition-delay:.32s; }

        /* Feature card */
        .feature-card { opacity:0; transform:translateY(24px); transition: opacity .5s ease, transform .5s cubic-bezier(0.23,1,0.32,1); }
        .feature-card.active { opacity:1; transform:translateY(0); }
        .feature-card:nth-child(2) { transition-delay:.12s; }
        .feature-card:nth-child(3) { transition-delay:.24s; }
        .feature-card:nth-child(4) { transition-delay:.36s; }

        /* Social card */
        .social-card { opacity:0; transform:translateY(16px); transition: opacity .45s ease, transform .45s cubic-bezier(0.23,1,0.32,1); }
        .social-card.active { opacity:1; transform:translateY(0); }
        .social-card:nth-child(1) { transition-delay:.06s; }
        .social-card:nth-child(2) { transition-delay:.12s; }
        .social-card:nth-child(3) { transition-delay:.18s; }
        .social-card:nth-child(4) { transition-delay:.24s; }

        /* Footer content */
        .footer-content { opacity:0; transform:translateY(24px); transition: opacity .6s ease, transform .6s cubic-bezier(0.23,1,0.32,1); }
        .footer-content.active { opacity:1; transform:translateY(0); }

        /* Scrollbar hide */
        .scrollbar-hide { -ms-overflow-style:none; scrollbar-width:none; }
        .scrollbar-hide::-webkit-scrollbar { display:none; }

        /* Category section */
        .category-section { transition: opacity .4s ease, transform .4s ease; }
        .category-section.hidden { display:none; }
        .category-section.active { animation: catIn .45s ease-out; }
        @keyframes catIn { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }

        /* SVG icon sizing */
        .icon-sm { width:18px; height:18px; }
        .icon-md { width:22px; height:22px; }
        .icon-lg { width:28px; height:28px; }
        .icon-xl { width:36px; height:36px; }

        /* Qty button */
        .qty-btn {
            display: flex; align-items: center; justify-content: center;
            transition: background-color .2s ease, transform .15s ease;
        }
        .qty-btn:active { transform: scale(0.88); }

        /* Nav bar floating */
        #topNav {
            position: sticky; top: 0; z-index: 50;
            background: rgba(14,12,10,0.85);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(184,146,74,0.15);
            transition: background .3s ease;
        }

        /* Gold divider line */
        .gold-line {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(184,146,74,0.6), transparent);
        }

        /* Floating cart */
        #cartSummary {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
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
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 mb-5 px-5 py-2 border border-[rgba(184,146,74,0.4)] rounded-full bg-[rgba(30,20,16,0.5)] backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm text-premium-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M19.8 15a2.25 2.25 0 01-2.15 1.5H6.35A2.25 2.25 0 014.2 15M19.8 15v-3M4.2 15v-3" />
                    </svg>
                    <span class="text-[var(--gold-pale)] text-xs font-medium tracking-widest uppercase">Premium Coffee Experience</span>
                </div>

                <h1 class="font-serif text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-semibold mb-4 md:mb-6 leading-[1.1]">
                    <span class="gradient-gold">NgopiGo</span><br>
                    <span class="text-white text-2xl sm:text-3xl md:text-4xl lg:text-[2.8rem] font-light tracking-wide">Taste the Excellence</span>
                </h1>

                <p class="text-sm sm:text-base md:text-lg text-white/75 mb-7 md:mb-10 leading-relaxed max-w-xl font-light">
                    Nikmati setiap tegukan kopi premium dari biji pilihan terbaik,<br class="hidden sm:block"> langsung ke cangkir Anda.
                </p>

                <div class="flex flex-wrap gap-3">
                    <a href="#menu" onclick="smoothScrollTo('menu')"
                       class="group inline-flex items-center gap-2 bg-[var(--gold)] hover:bg-[var(--gold-light)] text-[var(--black)] font-semibold py-3 px-7 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                        Pesan Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    <a href="#about" onclick="smoothScrollTo('about')"
                       class="inline-flex items-center gap-2 border border-[rgba(184,146,74,0.45)] hover:border-[var(--gold)] text-[var(--gold)] hover:bg-[rgba(184,146,74,0.08)] font-medium py-3 px-7 rounded-full transition-all duration-300 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        Tentang Kami
                    </a>
                </div>

                <!-- Stats -->
                <div class="flex gap-8 mt-10 pt-8 relative">
                    <div class="absolute inset-x-0 top-0 gold-line"></div>
                    <div class="text-left">
                        <div class="text-2xl sm:text-3xl font-serif font-semibold gradient-gold">20+</div>
                        <div class="text-xs text-white/60 mt-1 tracking-wide">Menu Premium</div>
                    </div>
                    <div class="text-left">
                        <div class="text-2xl sm:text-3xl font-serif font-semibold gradient-gold">100%</div>
                        <div class="text-xs text-white/60 mt-1 tracking-wide">Biji Arabika</div>
                    </div>
                    <div class="text-left">
                        <div class="text-2xl sm:text-3xl font-serif font-semibold gradient-gold">24/7</div>
                        <div class="text-xs text-white/60 mt-1 tracking-wide">Online Order</div>
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
    <section id="menu" class="py-12 md:py-16 lg:py-20 bg-gradient-to-b from-[var(--black)] to-[var(--dark-brown)]">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-6 md:mb-10 reveal">
                <span class="text-[var(--gold)] text-xs font-medium tracking-widest uppercase">Our Premium Selection</span>
                <h2 class="font-serif text-3xl sm:text-4xl md:text-5xl font-semibold mt-3 mb-3">
                    <span class="gradient-gold">Menu Favorit</span>
                </h2>
                <p class="text-white/60 max-w-md mx-auto text-sm font-light">
                    Pilihan menu terbaik dari barista profesional kami
                </p>
                <div class="gold-line max-w-xs mx-auto mt-5"></div>
            </div>

            <!-- Category Filter -->
            <div id="topNav" class="mb-8 md:mb-12">
                <div class="container mx-auto px-4">
                    <div class="flex gap-2 overflow-x-auto scrollbar-hide py-3" id="categoryFilter">
                        <button type="button" data-category="all"
                                class="category-btn flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-250 bg-[var(--gold)] text-[var(--black)] border border-[var(--gold)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                            </svg>
                            Semua
                        </button>
                        <button type="button" data-category="coffee"
                                class="category-btn flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-250 bg-transparent text-[var(--gold)] border border-[rgba(184,146,74,0.3)] hover:border-[var(--gold)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M19.8 15a2.25 2.25 0 01-2.15 1.5H6.35A2.25 2.25 0 014.2 15M19.8 15v-3M4.2 15v-3" />
                            </svg>
                            Coffee
                        </button>
                        <button type="button" data-category="non-coffee"
                                class="category-btn flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-250 bg-transparent text-[var(--gold)] border border-[rgba(184,146,74,0.3)] hover:border-[var(--gold)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                            </svg>
                            Non Coffee
                        </button>
                        <button type="button" data-category="food"
                                class="category-btn flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-250 bg-transparent text-[var(--gold)] border border-[rgba(184,146,74,0.3)] hover:border-[var(--gold)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0L3 16.5m15-3.379a48.474 48.474 0 00-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 013 20.625v-5.169c0-1.08.768-2.014 1.837-2.175A47.78 47.78 0 016 13.12M12.265 3.11a.375.375 0 11-.53 0L12 2.845l.265.265zm-3 0a.375.375 0 11-.53 0L9 2.845l.265.265zm6 0a.375.375 0 11-.53 0L15 2.845l.265.265z" />
                            </svg>
                            Food
                        </button>
                        <button type="button" data-category="snack"
                                class="category-btn flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-250 bg-transparent text-[var(--gold)] border border-[rgba(184,146,74,0.3)] hover:border-[var(--gold)]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                            Snacks
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
                    @foreach(['coffee' => ['icon' => 'coffee', 'name' => 'Signature Coffee'], 'non-coffee' => ['icon' => 'flame', 'name' => 'Non Coffee'], 'food' => ['icon' => 'food', 'name' => 'Premium Food'], 'snack' => ['icon' => 'gift', 'name' => 'Snacks & Bites']] as $categoryKey => $categoryData)
                        @if(isset($products[$categoryKey]) && $products[$categoryKey]->count() > 0)
                        <div class="mb-12 md:mb-16 reveal category-section" data-category="{{ $categoryKey }}">
                            <!-- Category Header -->
                            <div class="flex items-center gap-3 sm:gap-4 mb-6 sm:mb-8">
                                @if($categoryData['icon'] === 'coffee')
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon-xl text-[var(--gold)] opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15M14.25 3.104c.251.023.501.05.75.082M19.8 15a2.25 2.25 0 01-2.15 1.5H6.35A2.25 2.25 0 014.2 15M19.8 15v-3M4.2 15v-3" />
                                </svg>
                                @elseif($categoryData['icon'] === 'flame')
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon-xl text-[var(--gold)] opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                                </svg>
                                @elseif($categoryData['icon'] === 'food')
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon-xl text-[var(--gold)] opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75l-1.5.75a3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0 3.354 3.354 0 00-3 0 3.354 3.354 0 01-3 0L3 16.5m15-3.379a48.474 48.474 0 00-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 013 20.625v-5.169c0-1.08.768-2.014 1.837-2.175A47.78 47.78 0 016 13.12M12.265 3.11a.375.375 0 11-.53 0L12 2.845l.265.265zm-3 0a.375.375 0 11-.53 0L9 2.845l.265.265zm6 0a.375.375 0 11-.53 0L15 2.845l.265.265z" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon-xl text-[var(--gold)] opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                                @endif
                                <div>
                                    <h3 class="font-serif text-xl sm:text-2xl font-semibold text-[var(--gold-pale)]">{{ $categoryData['name'] }}</h3>
                                    <div class="w-12 h-px bg-[var(--gold)] mt-2 opacity-60"></div>
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
                    <div id="cartSummary" class="fixed bottom-0 left-0 right-0 bg-[rgba(20,13,9,0.92)] border-t border-[rgba(184,146,74,0.35)] shadow-2xl p-3 sm:p-4 md:p-5 transform translate-y-full transition-transform duration-300 z-50">
                        <div class="container mx-auto">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-4 sm:gap-8">
                                    <div>
                                        <div class="flex items-center gap-2 mb-0.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm text-[var(--gold)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                            </svg>
                                            <p class="text-[var(--gold)] text-xs font-semibold uppercase tracking-widest">Total Pesanan</p>
                                        </div>
                                        <p class="text-xl sm:text-2xl md:text-3xl font-serif font-semibold gradient-gold" id="cartTotal">Rp 0</p>
                                    </div>
                                    <div class="h-10 w-px bg-[rgba(184,146,74,0.3)] hidden sm:block"></div>
                                    <div class="hidden sm:block">
                                        <p class="text-white/50 text-xs mb-0.5 uppercase tracking-widest">Item</p>
                                        <p class="text-xl sm:text-2xl font-semibold text-white" id="cartCount">0</p>
                                    </div>
                                </div>
                                <button type="button" onclick="showCheckoutModal()"
                                        class="inline-flex items-center gap-2 bg-[var(--gold)] hover:bg-[var(--gold-light)] text-[var(--black)] font-semibold py-2.5 px-5 sm:py-3 sm:px-7 rounded-full shadow-lg transform hover:scale-105 transition-all duration-200 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                    </svg>
                                    <span class="hidden sm:inline">Lanjut ke Checkout</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>       </div>
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
                    <div class="grid grid-cols-2 gap-3 sm:gap-4 mt-6 sm:mt-8 reveal-stagger">
                        <div class="feature-card group relative bg-[rgba(14,12,10,0.7)] p-4 sm:p-5 rounded-2xl border border-[rgba(184,146,74,0.18)] hover:border-[rgba(184,146,74,0.4)] transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-[rgba(184,146,74,0.08)] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon-lg text-[var(--gold)] mb-3 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                                <div class="text-sm font-semibold text-[var(--gold-pale)] mb-0.5">Premium Quality</div>
                                <div class="text-xs text-white/50">Kualitas terbaik</div>
                            </div>
                        </div>
                        <div class="feature-card group relative bg-[rgba(14,12,10,0.7)] p-4 sm:p-5 rounded-2xl border border-[rgba(184,146,74,0.18)] hover:border-[rgba(184,146,74,0.4)] transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-[rgba(184,146,74,0.08)] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon-lg text-[var(--gold)] mb-3 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <div class="text-sm font-semibold text-[var(--gold-pale)] mb-0.5">Pro Barista</div>
                                <div class="text-xs text-white/50">Ahli kopi pilihan</div>
                            </div>
                        </div>
                        <div class="feature-card group relative bg-[rgba(14,12,10,0.7)] p-4 sm:p-5 rounded-2xl border border-[rgba(184,146,74,0.18)] hover:border-[rgba(184,146,74,0.4)] transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-[rgba(184,146,74,0.08)] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon-lg text-[var(--gold)] mb-3 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                </svg>
                                <div class="text-sm font-semibold text-[var(--gold-pale)] mb-0.5">Fresh Daily</div>
                                <div class="text-xs text-white/50">Bahan segar setiap hari</div>
                            </div>
                        </div>
                        <div class="feature-card group relative bg-[rgba(14,12,10,0.7)] p-4 sm:p-5 rounded-2xl border border-[rgba(184,146,74,0.18)] hover:border-[rgba(184,146,74,0.4)] transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-[rgba(184,146,74,0.08)] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon-lg text-[var(--gold)] mb-3 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                </svg>
                                <div class="text-sm font-semibold text-[var(--gold-pale)] mb-0.5">Fast Service</div>
                                <div class="text-xs text-white/50">Pelayanan cepat</div>
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
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center flex-shrink-0">
                            <svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.8"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        </div>
                        <div class="text-left hidden sm:block">
                            <div class="text-white font-bold">Instagram</div>
                            <div class="text-premium-gold text-sm">@ngopigo</div>
                        </div>
                    </a>

                    <!-- Facebook -->
                    <a href="https://facebook.com/ngopigo" target="_blank"
                       class="social-card group flex items-center gap-2 sm:gap-3 bg-gradient-to-r from-blue-900/50 to-blue-800/50 hover:from-blue-800/70 hover:to-blue-700/70 px-4 sm:px-6 py-3 sm:py-4 rounded-xl sm:rounded-2xl border border-premium-gold/30 hover:border-premium-gold transition-all duration-300 transform hover:-translate-y-1">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center flex-shrink-0">
                            <svg style="width:18px;height:18px" fill="white" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                        </div>
                        <div class="text-left hidden sm:block">
                            <div class="text-white font-bold">Facebook</div>
                            <div class="text-premium-gold text-sm">NgopiGo</div>
                        </div>
                    </a>

                    <!-- TikTok -->
                    <a href="https://tiktok.com/@ngopigo" target="_blank"
                       class="social-card group flex items-center gap-2 sm:gap-3 bg-gradient-to-r from-gray-900/50 to-gray-800/50 hover:from-gray-800/70 hover:to-gray-700/70 px-4 sm:px-6 py-3 sm:py-4 rounded-xl sm:rounded-2xl border border-premium-gold/30 hover:border-premium-gold transition-all duration-300 transform hover:-translate-y-1">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-gray-700 to-black flex items-center justify-center flex-shrink-0">
                            <svg style="width:18px;height:18px" fill="white" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.77.22 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.34 6.34 0 00-.79-.05 6.34 6.34 0 000 12.68 6.34 6.34 0 006.33-6.34V8.69a8.17 8.17 0 004.78 1.52V6.76a4.85 4.85 0 01-1.01-.07z"/></svg>
                        </div>
                        <div class="text-left hidden sm:block">
                            <div class="text-white font-bold">TikTok</div>
                            <div class="text-premium-gold text-sm">@ngopigo</div>
                        </div>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/6281234567890" target="_blank"
                       class="social-card group flex items-center gap-2 sm:gap-3 bg-gradient-to-r from-green-900/50 to-green-800/50 hover:from-green-800/70 hover:to-green-700/70 px-4 sm:px-6 py-3 sm:py-4 rounded-xl sm:rounded-2xl border border-premium-gold/30 hover:border-premium-gold transition-all duration-300 transform hover:-translate-y-1">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center flex-shrink-0">
                            <svg style="width:18px;height:18px" fill="white" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.998 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.978-1.405A9.96 9.96 0 0011.998 22C17.52 22 22 17.523 22 12S17.52 2 11.998 2zm0 18c-1.66 0-3.21-.476-4.524-1.3l-.323-.19-3.35.944.95-3.265-.21-.335A8 8 0 013.998 12c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8z"/></svg>
                        </div>
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
                        <p class="text-white/70 text-xs sm:text-sm font-medium flex items-center justify-center gap-1.5"><svg style="width:13px;height:13px;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg> Jakarta, Indonesia</p>
                        <p class="text-white/70 text-xs sm:text-sm font-medium flex items-center justify-center gap-1.5"><svg style="width:13px;height:13px;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg> hello@ngopigo.com</p>
                        <p class="text-white/70 text-xs sm:text-sm font-medium flex items-center justify-center gap-1.5"><svg style="width:13px;height:13px;flex-shrink:0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18h3"/></svg> +62 812-3456-7890</p>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="footer-content text-center sm:text-right">
                    <h4 class="text-base sm:text-lg font-bold text-white mb-3 sm:mb-4">Follow Us</h4>
                    <div class="flex justify-center sm:justify-end gap-3 sm:gap-4">
                        <a href="https://instagram.com/ngopigo" target="_blank" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center hover:scale-110 transition-transform shadow-lg">
                            <svg style="width:17px;height:17px" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.8"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        </a>
                        <a href="https://facebook.com/ngopigo" target="_blank" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center hover:scale-110 transition-transform shadow-lg">
                            <svg style="width:17px;height:17px" fill="white" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                        </a>
                        <a href="https://tiktok.com/@ngopigo" target="_blank" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-gray-700 to-black flex items-center justify-center hover:scale-110 transition-transform shadow-lg">
                            <svg style="width:17px;height:17px" fill="white" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.77.22 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.34 6.34 0 00-.79-.05 6.34 6.34 0 000 12.63 6.34 6.34 0 006.33-6.34V8.69a8.17 8.17 0 004.78 1.52V6.76a4.85 4.85 0 01-1.01-.07z"/></svg>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-green-500 to-green-700 flex items-center justify-center hover:scale-110 transition-transform shadow-lg">
                            <svg style="width:17px;height:17px" fill="white" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.978-1.405A9.96 9.96 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18c-1.66 0-3.21-.476-4.524-1.3l-.323-.19-3.35.944.95-3.265-.21-.335A8 8 0 014 12c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8z"/></svg>
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
    <div id="checkoutModal" class="fixed inset-0 bg-[rgba(0,0,0,0.88)] backdrop-blur-md z-50 hidden flex items-center justify-center p-2 sm:p-4 overflow-y-auto">
        <div class="bg-[var(--dark-brown)] rounded-2xl shadow-2xl w-full max-w-xl sm:max-w-2xl my-4 sm:my-8 max-h-[95vh] overflow-y-auto border border-[rgba(184,146,74,0.3)]">
            <!-- Modal Header -->
            <div class="bg-[var(--gold)] text-[var(--black)] px-5 sm:px-7 py-4 rounded-t-2xl flex items-center justify-between sticky top-0 z-10">
                <h2 class="font-serif text-lg sm:text-xl font-semibold flex items-center gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-md" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75M6.75 21h9" />
                    </svg>
                    Checkout Pesanan
                </h2>
                <button type="button" onclick="hideCheckoutModal()" class="text-[var(--black)] hover:text-white text-2xl font-bold transition-colors w-9 h-9 flex items-center justify-center rounded-full hover:bg-black/20">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="p-5 sm:p-7">
                <form action="{{ route('order.store') }}" method="POST" id="checkoutForm">
                    @csrf
                    <input type="hidden" name="table_number" value="{{ $tableNumber }}">

                    <!-- Order Summary -->
                    <div class="bg-[rgba(0,0,0,0.3)] rounded-xl p-4 sm:p-5 mb-5 border border-[rgba(184,146,74,0.2)]">
                        <h3 class="font-semibold text-[var(--gold)] mb-3 text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                            Ringkasan Pesanan
                        </h3>
                        <div id="checkoutItems" class="space-y-2 sm:space-y-3"></div>
                        <div class="relative mt-4 pt-4">
                            <div class="gold-line"></div>
                            <div class="flex justify-between items-center mt-4">
                                <span class="font-semibold text-white text-sm tracking-wide">Total Bayar</span>
                                <span class="font-serif text-2xl sm:text-3xl font-semibold gradient-gold" id="checkoutTotal">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="mb-5">
                        <h3 class="font-semibold text-white/80 mb-3 text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            Informasi Customer
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <label for="customer_name" class="block text-xs font-medium text-white/60 mb-1.5">Nama Panggilan <span class="text-[var(--gold)]">*</span></label>
                                <input type="text" name="customer_name" id="customer_name" required
                                       class="w-full px-4 py-2.5 bg-[rgba(0,0,0,0.3)] border border-[rgba(184,146,74,0.25)] rounded-xl focus:ring-1 focus:ring-[var(--gold)] focus:border-[var(--gold)] transition text-white placeholder-white/30 text-sm outline-none"
                                       placeholder="Masukkan nama panggilan">
                            </div>
                            <div>
                                <label for="phone" class="block text-xs font-medium text-white/60 mb-1.5">Nomor WhatsApp <span class="text-[var(--gold)]">*</span></label>
                                <input type="tel" name="phone" id="phone" required
                                       class="w-full px-4 py-2.5 bg-[rgba(0,0,0,0.3)] border border-[rgba(184,146,74,0.25)] rounded-xl focus:ring-1 focus:ring-[var(--gold)] focus:border-[var(--gold)] transition text-white placeholder-white/30 text-sm outline-none"
                                       placeholder="08123456789">
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="mb-5">
                        <h3 class="font-semibold text-white/80 mb-3 text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            Catatan Pesanan
                        </h3>
                        <textarea name="notes" id="notes" rows="3"
                                  class="w-full px-4 py-2.5 bg-[rgba(0,0,0,0.3)] border border-[rgba(184,146,74,0.25)] rounded-xl focus:ring-1 focus:ring-[var(--gold)] focus:border-[var(--gold)] transition text-white placeholder-white/30 text-sm outline-none resize-none"
                                  placeholder="Contoh: Kurang manis, tanpa es, dll"></textarea>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-white/80 mb-3 text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                            </svg>
                            Metode Pembayaran
                        </h3>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="cod" checked class="peer sr-only">
                                <div class="bg-[rgba(0,0,0,0.25)] border border-[rgba(184,146,74,0.25)] rounded-xl p-4 peer-checked:border-[var(--gold)] peer-checked:bg-[rgba(184,146,74,0.1)] transition-all hover:border-[rgba(184,146,74,0.45)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-md text-[var(--gold)] mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                    </svg>
                                    <div class="font-semibold text-white text-sm">Bayar di Tempat</div>
                                    <div class="text-xs text-white/50 mt-0.5">COD</div>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="online" class="peer sr-only">
                                <div class="bg-[rgba(0,0,0,0.25)] border border-[rgba(184,146,74,0.25)] rounded-xl p-4 peer-checked:border-[var(--gold)] peer-checked:bg-[rgba(184,146,74,0.1)] transition-all hover:border-[rgba(184,146,74,0.45)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-md text-[var(--gold)] mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                    </svg>
                                    <div class="font-semibold text-white text-sm">Bayar Online</div>
                                    <div class="text-xs text-white/50 mt-0.5">Transfer / E-Wallet</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-3">
                        <button type="button" onclick="hideCheckoutModal()"
                                class="px-5 py-3 border border-[rgba(184,146,74,0.3)] text-white/60 font-medium rounded-xl hover:bg-[rgba(184,146,74,0.08)] hover:border-[var(--gold)] hover:text-white transition text-sm">
                            Kembali
                        </button>
                        <button type="submit"
                                class="flex-1 inline-flex items-center justify-center gap-2 bg-[var(--gold)] hover:bg-[var(--gold-light)] text-[var(--black)] font-semibold py-3 px-5 rounded-xl shadow-lg transform hover:scale-[1.02] transition-all duration-200 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Buat Pesanan
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
                
                // Update active button styles
                document.querySelectorAll('.category-btn').forEach(b => {
                    b.style.backgroundColor = 'transparent';
                    b.style.color = 'var(--gold)';
                    b.style.borderColor = 'rgba(184,146,74,0.3)';
                    b.style.fontWeight = '500';
                });
                this.style.backgroundColor = 'var(--gold)';
                this.style.color = 'var(--black)';
                this.style.borderColor = 'var(--gold)';
                this.style.fontWeight = '600';
                
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

