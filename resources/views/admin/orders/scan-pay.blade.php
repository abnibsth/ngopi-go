<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Bayar - NgopiGo Kasir</title>
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --gold: #C69C6D;
            --dark: #1a120f;
            --darker: #121212;
        }

        @@keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @@keyframes popIn {
            0% { transform: scale(0.5); opacity: 0; }
            70% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        @@keyframes checkmark {
            0% { stroke-dashoffset: 100; }
            100% { stroke-dashoffset: 0; }
        }
        @@keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(2); opacity: 0; }
        }

        .slide-up { animation: slideUp 0.5s ease-out forwards; }
        .pop-in { animation: popIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }

        .success-ring {
            animation: pulse-ring 1.5s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }

        .btn-confirm {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            transition: all 0.2s ease;
            box-shadow: 0 4px 15px rgba(22, 163, 74, 0.4);
        }
        .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(22, 163, 74, 0.5);
        }
        .btn-confirm:active {
            transform: translateY(0);
        }

        .item-row {
            transition: background 0.2s;
        }
        .item-row:hover {
            background: rgba(198, 156, 109, 0.05);
        }
    </style>
</head>
<body class="bg-[#0d0806] min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full slide-up">

        {{-- Header Kasir --}}
        <div class="text-center mb-6">
            <div class="inline-flex items-center gap-2 bg-[#C69C6D]/20 border border-[#C69C6D]/30 text-[#C69C6D] text-sm font-semibold px-4 py-2 rounded-full mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Panel Kasir
            </div>
            <h1 class="text-2xl font-bold text-[#F5F0E6]">Konfirmasi Pembayaran</h1>
            <p class="text-[#C69C6D] text-sm mt-1">Periksa detail pesanan dan konfirmasi pembayaran tunai</p>
        </div>

        {{-- Already Paid Check --}}
        @if($order->payment_status === 'paid')
        <div class="bg-[#1a120f] rounded-2xl border border-green-500/30 p-8 text-center">
            <div class="relative flex justify-center mb-4">
                <div class="absolute w-20 h-20 bg-green-500/10 rounded-full success-ring"></div>
                <div class="w-20 h-20 bg-green-500/20 rounded-full flex items-center justify-center relative z-10">
                    <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <h2 class="text-xl font-bold text-green-400 mb-2">Sudah Lunas!</h2>
            <p class="text-[#C69C6D] text-sm">Pesanan <strong class="text-[#F5F0E6]">{{ $order->getFormattedOrderNumber() }}</strong> sudah dibayar.</p>
            <a href="{{ route('admin.orders.index') }}" 
               class="mt-6 inline-block bg-[#2E1F1A] hover:bg-[#3E2F2A] border border-[#C69C6D]/30 text-[#C69C6D] font-semibold py-3 px-6 rounded-xl transition">
                ← Kembali ke Daftar Pesanan
            </a>
        </div>

        @else
        {{-- Order Card --}}
        <div class="bg-[#1a120f] rounded-2xl border border-[#C69C6D]/20 overflow-hidden mb-4">

            {{-- Order Header --}}
            <div class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] px-6 py-4 border-b border-[#C69C6D]/20">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[#C69C6D] text-xs">No. Pesanan</p>
                        <p class="text-[#F5F0E6] font-bold text-lg font-mono">{{ $order->getFormattedOrderNumber() }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[#C69C6D] text-xs">Meja</p>
                        <p class="text-[#F5F0E6] font-bold text-lg">🪑 {{ $order->table_number }}</p>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-3 pt-3 border-t border-[#C69C6D]/10">
                    <div>
                        <p class="text-[#C69C6D] text-xs">Pelanggan</p>
                        <p class="text-[#F5F0E6] font-semibold">👤 {{ $order->customer_name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[#C69C6D] text-xs">Waktu Pesan</p>
                        <p class="text-[#F5F0E6] text-sm">{{ $order->created_at->format('H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="px-6 py-4 border-b border-[#C69C6D]/20">
                <p class="text-[#C69C6D] text-xs font-semibold mb-3 uppercase tracking-wider">Detail Pesanan</p>
                <div class="space-y-2">
                    @foreach($order->orderItems as $item)
                    <div class="item-row flex justify-between items-center py-2 px-2 rounded-lg">
                        <div class="flex-1">
                            <span class="text-[#C69C6D]/60 text-xs font-mono">{{ $order->getProductCode($item) }}</span>
                            <span class="text-[#F5F0E6] text-sm ml-2">{{ $item->quantity }}x {{ $item->product->name }}</span>
                        </div>
                        <span class="text-[#C69C6D] font-semibold text-sm">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                    @endforeach
                </div>

                @if($order->notes)
                <div class="mt-3 pt-3 border-t border-[#C69C6D]/10">
                    <p class="text-xs text-[#C69C6D]/70">📝 Catatan: <span class="text-[#F5F0E6]">{{ $order->notes }}</span></p>
                </div>
                @endif
            </div>

            {{-- Total --}}
            <div class="px-6 py-4">
                <div class="flex justify-between items-center">
                    <span class="text-[#F5F0E6] font-bold text-lg">Total Tagihan</span>
                    <span class="text-2xl font-bold" style="background: linear-gradient(135deg, #C69C6D, #F5DEB3); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></span>
                    <span class="text-yellow-400 text-xs">Menunggu pembayaran tunai</span>
                </div>
            </div>
        </div>

        {{-- Confirm Button --}}
        <form action="{{ route('cashier.confirm-payment', $order->order_number) }}" method="POST">
            @csrf
            <button type="submit" id="confirm-btn" class="btn-confirm w-full text-white font-bold py-4 px-6 rounded-xl text-lg flex items-center justify-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Konfirmasi Lunas — Rp {{ number_format($order->total_amount, 0, ',', '.') }}
            </button>
        </form>

        <button onclick="window.close()" 
                class="mt-3 w-full bg-transparent border border-[#C69C6D]/20 hover:border-[#C69C6D]/40 text-[#C69C6D] font-medium py-3 px-6 rounded-xl transition text-sm">
            ✕ Batalkan
        </button>
        @endif

    </div>

    <script>
        // Konfirmasi sebelum submit
        document.getElementById('confirm-btn')?.addEventListener('click', function(e) {
            const total = '{{ number_format($order->total_amount, 0, ",", ".") }}';
            const name = '{{ $order->customer_name }}';
            if (!confirm(`Konfirmasi pembayaran tunai:\n\n👤 ${name}\n💰 Rp ${total}\n\nLanjutkan?`)) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
