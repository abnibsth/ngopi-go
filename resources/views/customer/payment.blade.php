<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran — NgopiGo</title>
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Midtrans Snap JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>

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

        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--black);
            background-image:
                radial-gradient(ellipse at 20% 20%, rgba(184,146,74,0.05) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 80%, rgba(184,146,74,0.03) 0%, transparent 50%);
            color: var(--cream);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        h1, h2, .font-serif { font-family: 'Playfair Display', serif; }

        .gradient-gold {
            background: linear-gradient(120deg, #b8924a 0%, #e8d5b0 45%, #c4a265 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card {
            background: rgba(30,20,16,0.7);
            border: 1px solid rgba(184,146,74,0.2);
            border-radius: 1.5rem;
            backdrop-filter: blur(12px);
            overflow: hidden;
            max-width: 520px;
            width: 100%;
            box-shadow: 0 30px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(184,146,74,0.08);
            animation: slideUp 0.6s cubic-bezier(0.23, 1, 0.32, 1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card-header {
            background: linear-gradient(135deg, rgba(184,146,74,0.1) 0%, rgba(30,20,16,0) 60%);
            border-bottom: 1px solid rgba(184,146,74,0.15);
            padding: 2rem 2rem 1.5rem;
            text-align: center;
            position: relative;
        }

        .header-icon {
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 50%;
            background: rgba(184,146,74,0.1);
            border: 1px solid rgba(184,146,74,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            animation: pulse-icon 3s ease-in-out infinite;
        }

        @keyframes pulse-icon {
            0%, 100% { box-shadow: 0 0 0 0 rgba(184,146,74,0.3); }
            50%       { box-shadow: 0 0 0 12px rgba(184,146,74,0); }
        }

        .card-body { padding: 1.75rem 2rem; }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.85rem 0;
            border-bottom: 1px solid rgba(184,146,74,0.08);
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: rgba(184,146,74,0.7); font-size: 0.85rem; }
        .info-value { font-weight: 600; color: var(--cream); font-size: 0.9rem; }

        .info-block {
            background: rgba(184,146,74,0.04);
            border: 1px solid rgba(184,146,74,0.12);
            border-radius: 1rem;
            padding: 0.25rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .btn-pay {
            width: 100%;
            background: linear-gradient(120deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--black);
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 0.875rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 0 4px 20px rgba(184,146,74,0.3);
            letter-spacing: 0.02em;
        }
        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(184,146,74,0.4);
        }
        .btn-pay:active { transform: translateY(0); }

        .btn-fallback {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(184,146,74,0.05);
            border: 1px solid rgba(184,146,74,0.25);
            color: var(--cream);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        .btn-fallback:hover {
            background: rgba(184,146,74,0.12);
            border-color: rgba(184,146,74,0.4);
        }

        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            color: rgba(184,146,74,0.65);
            margin-top: 0.85rem;
        }

        .payment-methods {
            background: rgba(184,146,74,0.03);
            border-top: 1px solid rgba(184,146,74,0.1);
            padding: 1rem 2rem;
            text-align: center;
        }
        .payment-method-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(184,146,74,0.5);
            margin-bottom: 0.5rem;
        }
        .method-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            justify-content: center;
        }
        .method-chip {
            font-size: 0.7rem;
            background: rgba(184,146,74,0.08);
            border: 1px solid rgba(184,146,74,0.15);
            color: rgba(184,146,74,0.8);
            padding: 0.2rem 0.6rem;
            border-radius: 2rem;
        }

        .alert-error {
            background: rgba(248,113,113,0.07);
            border: 1px solid rgba(248,113,113,0.2);
            color: #fca5a5;
            padding: 0.875rem 1.25rem;
            border-radius: 0.75rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            font-size: 0.875rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: rgba(184,146,74,0.6);
            text-decoration: none;
            font-size: 0.85rem;
            margin-top: 1.5rem;
            transition: color 0.2s ease;
        }
        .back-link:hover { color: var(--gold); }

        .loading-dots span {
            display: inline-block;
            width: 5px; height: 5px;
            border-radius: 50%;
            background: var(--black);
            animation: dot-bounce 1.2s infinite;
            margin: 0 2px;
        }
        .loading-dots span:nth-child(2) { animation-delay: 0.2s; }
        .loading-dots span:nth-child(3) { animation-delay: 0.4s; }
        @keyframes dot-bounce {
            0%, 80%, 100% { transform: scale(0.7); opacity: 0.5; }
            40%            { transform: scale(1.0); opacity: 1; }
        }
    </style>
</head>
<body>
    <div style="text-align:center; width: 100%;">
        <div class="card" style="margin: 0 auto;">
            <!-- Header -->
            <div class="card-header">
                <div class="header-icon">
                    <svg class="w-7 h-7" style="color: var(--gold);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                    </svg>
                </div>
                <h1 class="font-serif" style="font-size: 1.6rem; font-weight: 700; margin-bottom: 0.25rem;" class="gradient-gold">
                    <span class="gradient-gold">Pembayaran Pesanan</span>
                </h1>
                <p style="color: rgba(184,146,74,0.7); font-size: 0.85rem;">Selesaikan pembayaran untuk memproses pesanan Anda</p>
            </div>

            <!-- Body -->
            <div class="card-body">
                @if(session('error'))
                <div class="alert-error">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <div>{{ session('error') }}</div>
                </div>
                @endif

                <!-- Order Info Block -->
                <div class="info-block">
                    <div class="info-row">
                        <span class="info-label">Nomor Pesanan</span>
                        <span class="info-value" style="font-family: monospace; color: var(--gold-pale); letter-spacing: 0.05em;">{{ $order->order_number }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nama</span>
                        <span class="info-value">{{ $order->customer_name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Meja</span>
                        <span class="info-value" style="display: flex; align-items: center; gap: 0.4rem;">
                            <svg class="w-4 h-4" style="color: rgba(184,146,74,0.6);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            {{ $order->table_number }}
                        </span>
                    </div>
                    <div class="info-row" style="border-bottom: none;">
                        <span class="info-label">Total Pembayaran</span>
                        <span style="font-size: 1.4rem; font-weight: 700;" class="gradient-gold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Pay Button -->
                <div style="text-align: center;">
                    <button id="pay-button" class="btn-pay">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span id="pay-text">Bayar Sekarang</span>
                        <span id="pay-loading" class="loading-dots" style="display: none;"><span></span><span></span><span></span></span>
                    </button>

                    <div class="security-badge" style="justify-content: center;">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                        Pembayaran aman dengan Midtrans
                    </div>

                    <!-- Fallback -->
                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(184,146,74,0.1);">
                        <p style="font-size: 0.75rem; color: rgba(184,146,74,0.5); margin-bottom: 0.75rem;">Jika tombol di atas tidak berfungsi:</p>
                        <a href="{{ $midtransUrl }}" target="_blank" class="btn-fallback">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                            Buka di Halaman Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer: Payment Methods -->
            <div class="payment-methods">
                <p class="payment-method-label">Metode Pembayaran Tersedia</p>
                <div class="method-chips">
                    <span class="method-chip">Transfer Bank</span>
                    <span class="method-chip">GoPay</span>
                    <span class="method-chip">OVO</span>
                    <span class="method-chip">ShopeePay</span>
                    <span class="method-chip">QRIS</span>
                    <span class="method-chip">Kartu Kredit</span>
                </div>
            </div>
        </div>

        <!-- Back Link -->
        <a href="{{ route('order.create') }}" class="back-link">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Pemesanan
        </a>
    </div>

    <script>
        const snapToken = '{{ $snapToken }}';
        const clientKey = '{{ $clientKey }}';
        const successUrl = '{{ url("/pesanan/" . $order->order_number) }}';

        document.addEventListener('DOMContentLoaded', function() {
            const payButton = document.getElementById('pay-button');
            const payText   = document.getElementById('pay-text');
            const payLoading = document.getElementById('pay-loading');
            if (!payButton) return;

            function triggerPayment() {
                if (!snapToken || snapToken.length < 10) {
                    alert('Token pembayaran tidak valid. Gunakan tombol "Buka di Halaman Baru".');
                    return;
                }

                if (typeof snap === 'undefined') {
                    alert('Midtrans tidak tersedia. Gunakan tombol "Buka di Halaman Baru".');
                    return;
                }

                // Show loading state
                payText.style.display = 'none';
                payLoading.style.display = 'inline-flex';
                payButton.disabled = true;

                try {
                    snap.pay(snapToken, {
                        onSuccess: function(result) {
                            window.location.href = successUrl;
                        },
                        onPending: function(result) {
                            window.location.href = successUrl;
                        },
                        onError: function(result) {
                            payText.style.display = 'inline';
                            payLoading.style.display = 'none';
                            payButton.disabled = false;
                            alert('Pembayaran gagal. Silakan coba lagi.');
                        },
                        onClose: function() {
                            payText.style.display = 'inline';
                            payLoading.style.display = 'none';
                            payButton.disabled = false;
                        }
                    });
                } catch (error) {
                    payText.style.display = 'inline';
                    payLoading.style.display = 'none';
                    payButton.disabled = false;
                    alert('Gagal membuka popup pembayaran. Gunakan tombol "Buka di Halaman Baru".');
                }
            }

            payButton.addEventListener('click', function(e) {
                e.preventDefault();
                triggerPayment();
            });

            // Auto-open after 1 second
            setTimeout(function() {
                if (typeof snap !== 'undefined' && snapToken && snapToken.length >= 10) {
                    triggerPayment();
                }
            }, 1200);
        });
    </script>
</body>
</html>
