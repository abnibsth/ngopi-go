<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NgopiGo - Premium Coffee & Bites</title>
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
        
        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .floating {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-premium-black text-cream min-h-screen">
    <!-- Hero Section with Slider -->
    <section class="relative h-[600px] overflow-hidden">
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
                
                <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                    <span class="gradient-gold">NgopiGo</span>
                    <br>
                    <span class="text-white text-4xl md:text-5xl">Taste the Excellence</span>
                </h1>
                
                <p class="text-lg md:text-xl text-gray-300 mb-8 leading-relaxed max-w-2xl">
                    Nikmati setiap tegukan kopi premium pilihan dengan cita rasa autentik. 
                    Dari biji kopi terbaik langsung ke cangkir Anda.
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="#menu" 
                       class="group bg-premium-gold hover:bg-gold-light text-premium-black font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-premium-gold/50">
                        🛒 Pesan Sekarang
                        <span class="inline-block ml-2 group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                    <a href="#about" 
                       class="border-2 border-premium-gold/50 hover:border-premium-gold text-premium-gold font-bold py-4 px-8 rounded-full transition-all duration-300 hover:bg-premium-gold/10">
                        ℹ️ Tentang Kami
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-premium-gold/20">
                    <div>
                        <div class="text-3xl font-bold gradient-gold">20+</div>
                        <div class="text-sm text-gray-400 mt-1">Menu Premium</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold gradient-gold">100%</div>
                        <div class="text-sm text-gray-400 mt-1">Biji Arabika</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold gradient-gold">24/7</div>
                        <div class="text-sm text-gray-400 mt-1">Online Order</div>
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
    <section id="menu" class="py-20 bg-gradient-to-b from-premium-black to-premium-brown">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="text-premium-gold text-sm font-medium tracking-wider uppercase">Our Premium Selection</span>
                <h2 class="text-4xl md:text-5xl font-bold mt-4 mb-6">
                    <span class="gradient-gold">Menu Favorit</span>
                </h2>
                <p class="text-gray-400 max-w-2xl mx-auto text-lg">
                    Pilihan menu terbaik dari barista profesional kami
                </p>
            </div>

            <!-- Main Content -->
            <main class="container mx-auto px-4 py-8">
                <form action="{{ route('order.store') }}" method="POST" id="orderForm">
                    @csrf
                    <input type="hidden" name="table_number" value="{{ $tableNumber }}">
                    
                    <!-- Menu Categories -->
                    @foreach(['coffee' => ['icon' => '☕', 'name' => 'Signature Coffee'], 'non-coffee' => ['icon' => '🍵', 'name' => 'Non Coffee'], 'food' => ['icon' => '🍛', 'name' => 'Premium Food'], 'snack' => ['icon' => '🍟', 'name' => 'Snacks & Bites']] as $categoryKey => $categoryData)
                        @if(isset($products[$categoryKey]) && $products[$categoryKey]->count() > 0)
                        <div class="mb-16">
                            <!-- Category Header -->
                            <div class="flex items-center gap-4 mb-8">
                                <div class="text-4xl">{{ $categoryData['icon'] }}</div>
                                <div>
                                    <h3 class="text-3xl font-bold text-premium-gold">{{ $categoryData['name'] }}</h3>
                                    <div class="w-24 h-1 bg-premium-gold mt-2"></div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($products[$categoryKey] as $product)
                                <div class="product-card premium-card gold-border-animate bg-premium-brown/50 rounded-2xl overflow-hidden border border-premium-gold/20 cursor-pointer" 
                                     data-product-id="{{ $product->id }}"
                                     data-product-name="{{ $product->name }}"
                                     data-product-price="{{ $product->price }}">
                                    <!-- Product Image -->
                                    @if($product->image)
                                    <div class="relative h-48 overflow-hidden">
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500">
                                        <div class="absolute inset-0 bg-gradient-to-t from-premium-brown to-transparent"></div>
                                    </div>
                                    @else
                                    <div class="h-48 bg-gradient-to-br from-premium-brown to-premium-black flex items-center justify-center">
                                        <span class="text-6xl opacity-50">📷</span>
                                    </div>
                                    @endif
                                    
                                    <!-- Product Content -->
                                    <div class="p-6">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex-1">
                                                <h4 class="text-xl font-bold text-white mb-2">{{ $product->name }}</h4>
                                                <p class="text-sm text-gray-400 line-clamp-2">{{ $product->description }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-premium-gold/20">
                                            <span class="text-2xl font-bold gradient-gold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                            <div class="flex items-center gap-2">
                                                <button type="button" 
                                                        class="btn-minus w-10 h-10 rounded-full bg-premium-black/50 hover:bg-premium-gold/20 border border-premium-gold/30 flex items-center justify-center font-bold text-premium-gold transition-all"
                                                        onclick="event.stopPropagation(); updateQuantity({{ $product->id }}, -1)">
                                                    −
                                                </button>
                                                <input type="number" 
                                                       name="items[{{ $product->id }}][quantity]" 
                                                       id="qty-{{ $product->id }}" 
                                                       class="qty-input w-14 text-center bg-premium-black/50 border border-premium-gold/30 rounded-lg py-2 font-bold text-premium-gold focus:border-premium-gold focus:outline-none"
                                                       value="0" 
                                                       min="0" 
                                                       max="99"
                                                       onclick="event.stopPropagation()"
                                                       onchange="updateQuantity({{ $product->id }}, 0)">
                                                <input type="hidden" name="items[{{ $product->id }}][product_id]" value="{{ $product->id }}">
                                                <button type="button" 
                                                        class="btn-plus w-10 h-10 rounded-full bg-premium-gold hover:bg-gold-light flex items-center justify-center font-bold text-premium-black transition-all"
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
                <div id="cartSummary" class="fixed bottom-0 left-0 right-0 bg-gradient-to-r from-[#2E1F1A] via-[#1a120f] to-[#2E1F1A] border-t-4 border-[#C69C6D] shadow-2xl p-6 transform translate-y-full transition-transform duration-300 z-50">
                    <div class="container mx-auto">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-8">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-2xl">🛒</span>
                                        <p class="text-[#C69C6D] text-sm font-semibold uppercase tracking-wider">Total Pesanan</p>
                                    </div>
                                    <p class="text-4xl font-bold bg-gradient-to-r from-[#C69C6D] to-[#F5DEB3] bg-clip-text text-transparent" id="cartTotal">Rp 0</p>
                                </div>
                                <div class="h-16 w-px bg-gradient-to-b from-transparent via-[#C69C6D] to-transparent"></div>
                                <div class="text-center">
                                    <p class="text-gray-400 text-sm mb-1 font-semibold uppercase tracking-wider">Total Item</p>
                                    <p class="text-4xl font-bold text-white" id="cartCount">0</p>
                                </div>
                            </div>
                            <button type="button"
                                    onclick="showCheckoutModal()"
                                    class="bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] hover:from-[#D4AF7A] hover:to-[#C69C6D] text-[#121212] font-bold py-4 px-10 rounded-full shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center gap-3">
                                    <span class="text-2xl">🛒</span>
                                    <span class="text-lg">Lanjut ke Checkout</span>
                                    <span class="text-xl">→</span>
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-premium-brown">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-premium-gold text-sm font-medium tracking-wider uppercase">Our Story</span>
                    <h2 class="text-4xl md:text-5xl font-bold mt-4 mb-6 text-white">
                        Crafted with <span class="gradient-gold">Passion</span>
                    </h2>
                    <p class="text-gray-300 text-lg leading-relaxed mb-6">
                        NgopiGo menghadirkan pengalaman kopi premium dengan biji kopi pilihan dari seluruh nusantara. 
                        Setiap cangkir dibuat dengan hati-hati oleh barista profesional kami.
                    </p>
                    <div class="grid grid-cols-2 gap-6 mt-8">
                        <div class="bg-premium-black/50 p-6 rounded-xl border border-premium-gold/20">
                            <div class="text-4xl mb-3">🌟</div>
                            <div class="text-2xl font-bold gradient-gold mb-1">Premium</div>
                            <div class="text-sm text-gray-400">Kualitas Terbaik</div>
                        </div>
                        <div class="bg-premium-black/50 p-6 rounded-xl border border-premium-gold/20">
                            <div class="text-4xl mb-3">👨‍🍳</div>
                            <div class="text-2xl font-bold gradient-gold mb-1">Professional</div>
                            <div class="text-sm text-gray-400">Barista Ahli</div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute inset-0 bg-premium-gold/20 blur-3xl rounded-full"></div>
                    <img src="https://images.unsplash.com/photo-1442512595331-e89e7385a861?w=800&h=600&fit=crop" 
                         alt="Coffee Art" 
                         class="relative rounded-2xl shadow-2xl border-2 border-premium-gold/30 w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-premium-black py-12 border-t border-premium-gold/20">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h3 class="text-3xl font-bold gradient-gold mb-4">NgopiGo</h3>
                <p class="text-gray-400 mb-6">Premium Coffee Experience</p>
                <div class="flex justify-center gap-6 mb-8">
                    <a href="#" class="text-premium-gold hover:text-gold-light transition-colors text-2xl">📱</a>
                    <a href="#" class="text-premium-gold hover:text-gold-light transition-colors text-2xl">📧</a>
                    <a href="#" class="text-premium-gold hover:text-gold-light transition-colors text-2xl">📍</a>
                </div>
                <p class="text-gray-500 text-sm">
                    © {{ date('Y') }} NgopiGo. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Checkout Modal -->
    <div id="checkoutModal" class="fixed inset-0 bg-black/90 backdrop-blur-md z-50 hidden flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-gradient-to-br from-[#2E1F1A] to-[#1a120f] rounded-3xl shadow-2xl w-full max-w-2xl my-8 max-h-[90vh] overflow-y-auto border-2 border-[#C69C6D]/40">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] text-[#121212] px-8 py-6 rounded-t-3xl flex items-center justify-between sticky top-0 z-10">
                <h2 class="text-2xl font-bold flex items-center gap-3">
                    <span class="text-3xl">📝</span>
                    <span>Checkout Pesanan</span>
                </h2>
                <button type="button" onclick="hideCheckoutModal()" class="text-[#121212] hover:text-white text-3xl font-bold transition-colors w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/20">
                    &times;
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-8">
                <form action="{{ route('order.store') }}" method="POST" id="checkoutForm">
                    @csrf
                    <input type="hidden" name="table_number" value="{{ $tableNumber }}">
                    
                    <!-- Order Summary -->
                    <div class="bg-[#121212]/80 rounded-2xl p-6 mb-6 border-2 border-[#C69C6D]/30">
                        <h3 class="font-bold text-[#C69C6D] mb-4 text-lg flex items-center gap-2">
                            <span class="text-2xl">🛒</span>
                            <span>Ringkasan Pesanan</span>
                        </h3>
                        <div id="checkoutItems" class="space-y-3">
                            <!-- Items populated by JS -->
                        </div>
                        <div class="border-t-2 border-[#C69C6D]/40 mt-4 pt-4 flex justify-between items-center">
                            <span class="font-bold text-white text-lg">Total Bayar</span>
                            <span class="text-3xl font-bold bg-gradient-to-r from-[#C69C6D] to-[#F5DEB3] bg-clip-text text-transparent" id="checkoutTotal">Rp 0</span>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="mb-6">
                        <h3 class="font-bold text-white mb-4 text-lg flex items-center gap-2">
                            <span class="text-2xl">👤</span>
                            <span>Informasi Customer</span>
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap <span class="text-[#C69C6D]">*</span></label>
                                <input type="text" 
                                       name="customer_name" 
                                       id="customer_name" 
                                       required
                                       class="w-full px-4 py-3 bg-[#121212]/60 border-2 border-[#C69C6D]/30 rounded-xl focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition text-white placeholder-gray-500"
                                       placeholder="Masukkan nama Anda">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Nomor WhatsApp <span class="text-[#C69C6D]">*</span></label>
                                    <input type="tel" 
                                           name="phone" 
                                           id="phone" 
                                           required
                                           class="w-full px-4 py-3 bg-[#121212]/60 border-2 border-[#C69C6D]/30 rounded-xl focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition text-white placeholder-gray-500"
                                           placeholder="08123456789">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           class="w-full px-4 py-3 bg-[#121212]/60 border-2 border-[#C69C6D]/30 rounded-xl focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition text-white placeholder-gray-500"
                                           placeholder="email@contoh.com">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="mb-6">
                        <h3 class="font-bold text-white mb-4 text-lg flex items-center gap-2">
                            <span class="text-2xl">📝</span>
                            <span>Catatan Pesanan</span>
                        </h3>
                        <textarea name="notes" 
                                  id="notes" 
                                  rows="3"
                                  class="w-full px-4 py-3 bg-[#121212]/60 border-2 border-[#C69C6D]/30 rounded-xl focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition text-white placeholder-gray-500"
                                  placeholder="Contoh: Jangan terlalu manis, kurang es batu, dll"></textarea>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-8">
                        <h3 class="font-bold text-white mb-4 text-lg flex items-center gap-2">
                            <span class="text-2xl">💳</span>
                            <span>Metode Pembayaran</span>
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="relative cursor-pointer">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="cod" 
                                       checked
                                       class="peer sr-only">
                                <div class="bg-[#121212]/60 border-2 border-[#C69C6D]/30 rounded-2xl p-5 peer-checked:border-[#C69C6D] peer-checked:bg-[#C69C6D]/10 transition-all hover:border-[#C69C6D]/50">
                                    <div class="text-3xl mb-2">💵</div>
                                    <div class="font-bold text-white">Bayar di Tempat</div>
                                    <div class="text-sm text-gray-400">COD - Cash on Delivery</div>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="online" 
                                       class="peer sr-only">
                                <div class="bg-[#121212]/60 border-2 border-[#C69C6D]/30 rounded-2xl p-5 peer-checked:border-[#C69C6D] peer-checked:bg-[#C69C6D]/10 transition-all hover:border-[#C69C6D]/50">
                                    <div class="text-3xl mb-2">💳</div>
                                    <div class="font-bold text-white">Bayar Online</div>
                                    <div class="text-sm text-gray-400">Transfer Bank / E-Wallet</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4">
                        <button type="button" 
                                onclick="hideCheckoutModal()"
                                class="px-6 py-4 border-2 border-[#C69C6D]/30 text-gray-300 font-bold rounded-xl hover:bg-[#C69C6D]/10 hover:border-[#C69C6D] transition text-center">
                            Kembali
                        </button>
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] hover:from-[#D4AF7A] hover:to-[#C69C6D] text-[#121212] font-bold py-4 px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center gap-2">
                            <span class="text-2xl">✅</span>
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
                            <div class="flex justify-between items-center p-4 bg-gradient-to-r from-[#1a120f] to-[#121212] rounded-xl border border-[#C69C6D]/20">
                                <div class="flex items-center gap-3">
                                    <span class="bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] text-[#121212] font-bold text-sm px-3 py-1 rounded-full">${qty}x</span>
                                    <span class="text-white font-medium">${product.name}</span>
                                </div>
                                <span class="text-[#C69C6D] font-bold">Rp ${subtotal.toLocaleString('id-ID')}</span>
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

        // Add click effect to product cards
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (!e.target.classList.contains('btn-minus') && 
                    !e.target.classList.contains('btn-plus') && 
                    !e.target.classList.contains('qty-input') &&
                    e.target.tagName !== 'INPUT') {
                    const productId = this.dataset.productId;
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
    </script>
</body>
</html>
