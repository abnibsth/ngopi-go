<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - NgopiGo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Midtrans Snap JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    
    <style>
        /* Custom Premium Colors */
        :root {
            --black: #121212;
            --dark-brown: #2E1F1A;
            --gold: #C69C6D;
            --gold-light: #D4AF7A;
            --cream: #F5F0E6;
        }

        .gradient-gold {
            background: linear-gradient(135deg, #C69C6D 0%, #F5DEB3 50%, #C69C6D 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .loading-spinner {
            border: 4px solid rgba(198, 156, 109, 0.1);
            border-left-color: #C69C6D;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-[#121212] text-[#F5F0E6] min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <!-- Payment Card -->
        <div class="bg-[#1a120f] rounded-2xl shadow-2xl overflow-hidden border border-[#C69C6D]/30">
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] px-8 py-6 border-b border-[#C69C6D]/30">
                <div class="text-center">
                    <div class="text-5xl mb-3">💳</div>
                    <h1 class="text-2xl font-bold gradient-gold">Pembayaran Pesanan</h1>
                    <p class="text-[#C69C6D] mt-1">Selesaikan pembayaran Anda</p>
                </div>
            </div>

            <!-- Order Info -->
            <div class="px-8 py-6">
                @if(session('error'))
                <div class="bg-[#2f1a1a] border border-[#f87171]/50 text-[#f87171] px-4 py-3 rounded-lg mb-6">
                    ⚠️ {{ session('error') }}
                </div>
                @endif

                <div class="bg-[#2E1F1A]/50 rounded-xl p-6 border border-[#C69C6D]/20 mb-6">
                    <div class="flex justify-between items-center mb-4 pb-4 border-b border-[#C69C6D]/20">
                        <span class="text-[#C69C6D]">Nomor Pesanan</span>
                        <span class="font-bold text-[#F5F0E6]">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-4 pb-4 border-b border-[#C69C6D]/20">
                        <span class="text-[#C69C6D]">Nama</span>
                        <span class="font-semibold text-[#F5F0E6]">{{ $order->customer_name }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-4 pb-4 border-b border-[#C69C6D]/20">
                        <span class="text-[#C69C6D]">Total Pembayaran</span>
                        <span class="text-2xl font-bold gradient-gold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Payment Button -->
                <div class="text-center">
                    <button id="pay-button"
                            class="w-full bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] hover:from-[#D4AF7A] hover:to-[#C69C6D] text-[#121212] font-bold py-4 px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200 text-lg">
                        🚀 Bayar Sekarang
                    </button>

                    <p class="text-[#C69C6D] text-sm mt-4">
                        🔒 Pembayaran aman dengan Midtrans
                    </p>

                    <!-- Fallback Link -->
                    <div class="mt-6 pt-6 border-t border-[#C69C6D]/20">
                        <p class="text-xs text-[#C69C6D] mb-3">Jika tombol di atas tidak berfungsi:</p>
                        <a href="{{ $midtransUrl }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 bg-[#2E1F1A] hover:bg-[#3E2F2A] border border-[#C69C6D]/50 text-[#F5F0E6] font-semibold py-3 px-6 rounded-lg transition">
                            🔗 Buka di Halaman Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-[#2E1F1A]/50 px-8 py-4 text-center border-t border-[#C69C6D]/20">
                <p class="text-sm text-[#C69C6D]">
                    💳 Transfer Bank • 📱 E-Wallet (GoPay, OVO, ShopeePay) • 📱 QRIS
                </p>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-6">
            <a href="{{ route('order.create') }}" 
               class="text-[#C69C6D] hover:text-[#D4AF7A] transition text-sm">
                ← Kembali ke Pemesanan
            </a>
        </div>
    </div>

    <script>
        // Snap Token dan Client Key dari server
        const snapToken = '{{ $snapToken }}';
        const clientKey = '{{ $clientKey }}';
        const orderNumber = '{{ $order->order_number }}';
        const successUrl = '{{ url("/pesanan/" . $order->order_number) }}';

        console.log('=== MIDTRANS PAYMENT PAGE ===');
        console.log('Snap Token:', snapToken);
        console.log('Snap Token Length:', snapToken ? snapToken.length : 0);
        console.log('Client Key:', clientKey);
        console.log('Order Number:', orderNumber);

        // Validate snap token
        if (!snapToken || snapToken === '' || snapToken.length < 10) {
            console.error('❌ INVALID SNAP TOKEN! Token is empty or too short.');
            alert('ERROR: Snap token tidak valid. Silakan buat pesanan baru atau gunakan tombol "Buka di Halaman Baru".');
        }

        // Wait for DOM to be ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded');
            
            // Check if snap is loaded
            if (typeof snap === 'undefined') {
                console.error('❌ Midtrans Snap JS NOT loaded!');
            } else {
                console.log('✅ Midtrans Snap JS loaded successfully');
                console.log('Snap object:', snap);
            }

            // Get pay button
            const payButton = document.getElementById('pay-button');
            if (!payButton) {
                console.error('❌ Pay button not found!');
                return;
            }
            
            console.log('✅ Pay button found:', payButton);

            // Pay button click handler
            payButton.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('🔘 Pay button clicked!');

                // Validate snap token again
                if (!snapToken || snapToken === '') {
                    alert('Snap token tidak valid. Silakan gunakan tombol "Buka di Halaman Baru".');
                    return;
                }

                if (typeof snap !== 'undefined') {
                    console.log('🚀 Opening Snap popup...');
                    try {
                        snap.pay(snapToken, {
                            onSuccess: function(result) {
                                console.log('✅ Payment success:', result);
                                window.location.href = successUrl;
                            },
                            onPending: function(result) {
                                console.log('⏳ Payment pending:', result);
                                window.location.href = successUrl;
                            },
                            onError: function(result) {
                                console.error('❌ Payment error:', result);
                                alert('Pembayaran gagal. Silakan coba lagi atau gunakan tombol "Buka di Halaman Baru".');
                            },
                            onClose: function() {
                                console.log('❌ Payment popup closed by user');
                            }
                        });
                    } catch (error) {
                        console.error('Snap.pay() error:', error);
                        alert('Error membuka popup pembayaran. Gunakan tombol "Buka di Halaman Baru".');
                    }
                } else {
                    console.error('❌ Snap object not available');
                    alert('Midtrans tidak tersedia. Silakan gunakan tombol "Buka di Halaman Baru".');
                }
            });

            // Auto-open snap after 1 second
            setTimeout(function() {
                console.log('⏰ Auto-triggering payment popup...');
                if (typeof snap !== 'undefined' && payButton && snapToken) {
                    payButton.click();
                }
            }, 1000);
        });
    </script>
</body>
</html>
