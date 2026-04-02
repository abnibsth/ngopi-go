<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pesanan - NgopiGo Admin</title>
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom Premium Colors - Same as All Admin Pages */
        :root {
            --black: #121212;
            --dark-brown: #2E1F1A;
            --gold: #C69C6D;
            --gold-light: #D4AF7A;
            --cream: #F5F0E6;
        }

        .bg-premium-black { background-color: var(--black); }
        .bg-premium-brown { background-color: var(--dark-brown); }
        .text-premium-gold { color: var(--gold); }

        /* Gradient Text */
        .gradient-gold {
            background: linear-gradient(135deg, #C69C6D 0%, #F5DEB3 50%, #C69C6D 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: var(--dark-brown); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--gold-light); }

        /* Select Dropdown */
        select option {
            background-color: #2E1F1A;
            color: #F5F0E6;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .hover-lift {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(198, 156, 109, 0.25);
        }
    </style>
</head>
<body class="bg-premium-black text-[#F5F0E6] min-h-screen">

    <!-- Header -->
    <header class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] border-b border-[#C69C6D]/30 shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold gradient-gold">✏️ Edit Pesanan</h1>
                    <p class="text-[#C69C6D] mt-1">{{ $order->order_number }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-white text-sm">
                        <span class="text-[#C69C6D]">Halo,</span>
                        <span class="font-semibold ml-1 text-[#F5F0E6]">{{ auth()->guard('admin')->user()->name }}</span>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-[#C69C6D] hover:bg-[#D4AF7A] text-[#121212] font-semibold py-2 px-4 rounded-lg transition text-sm shadow-lg">
                            🚪 Logout
                        </button>
                    </form>
                    <a href="{{ route('admin.orders.index') }}"
                       class="bg-[#C69C6D]/20 hover:bg-[#C69C6D]/40 border border-[#C69C6D]/50 text-[#F5F0E6] font-semibold py-2 px-4 rounded-lg transition backdrop-blur-sm">
                        ← Kembali ke Pesanan
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto fade-in">

            @if(session('success'))
            <div class="bg-[#1a2f1a] border border-[#4ade80]/50 text-[#4ade80] px-4 py-3 rounded-lg mb-6 shadow-lg">
                ✅ {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-[#2f1a1a] border border-[#f87171]/50 text-[#f87171] px-4 py-3 rounded-lg mb-6 shadow-lg">
                ⚠️ {{ session('error') }}
            </div>
            @endif

            <!-- Card Utama -->
            <div class="bg-[#1a120f] rounded-2xl shadow-2xl overflow-hidden border border-[#C69C6D]/20">

                <!-- Card Header -->
                <div class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] px-8 py-5 border-b border-[#C69C6D]/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#C69C6D]/20 border border-[#C69C6D]/40 flex items-center justify-center text-xl">
                            📋
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-[#F5F0E6]">Detail Pesanan</h2>
                            <p class="text-sm text-[#C69C6D]">Perbarui status pesanan</p>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-6">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Info Grid -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-[#2E1F1A]/50 rounded-xl p-4 border border-[#C69C6D]/20">
                                <p class="text-xs font-medium text-[#C69C6D] uppercase tracking-wider mb-1">Nomor Pesanan</p>
                                <p class="text-base font-bold text-[#F5F0E6]">{{ $order->order_number }}</p>
                            </div>
                            <div class="bg-[#2E1F1A]/50 rounded-xl p-4 border border-[#C69C6D]/20">
                                <p class="text-xs font-medium text-[#C69C6D] uppercase tracking-wider mb-1">Meja</p>
                                <p class="text-base font-bold text-[#F5F0E6]">🪑 {{ $order->table_number }}</p>
                            </div>
                            <div class="bg-[#2E1F1A]/50 rounded-xl p-4 border border-[#C69C6D]/20">
                                <p class="text-xs font-medium text-[#C69C6D] uppercase tracking-wider mb-1">Pelanggan</p>
                                <p class="text-base font-semibold text-[#F5F0E6]">{{ $order->customer_name ?? '-' }}</p>
                                <p class="text-xs text-[#C69C6D] mt-0.5">📱 {{ $order->phone }}</p>
                            </div>
                            <div class="bg-[#2E1F1A]/50 rounded-xl p-4 border border-[#C69C6D]/20">
                                <p class="text-xs font-medium text-[#C69C6D] uppercase tracking-wider mb-1">Total Pembayaran</p>
                                <p class="text-xl font-bold gradient-gold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="mb-6">
                            <p class="text-xs font-medium text-[#C69C6D] uppercase tracking-wider mb-2">Metode Pembayaran</p>
                            @if($order->payment_method === 'cod')
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-medium bg-[#1a2f1a] text-[#4ade80] border border-[#4ade80]/30">
                                    💵 COD (Bayar di Tempat)
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-medium bg-[#1a2330] text-[#60a5fa] border border-[#60a5fa]/30">
                                    💳 Online Payment
                                </span>
                            @endif
                        </div>

                        <!-- Item Pesanan -->
                        <div class="mb-6">
                            <p class="text-xs font-medium text-[#C69C6D] uppercase tracking-wider mb-3">Item Pesanan</p>
                            <div class="bg-[#2E1F1A]/30 rounded-xl border border-[#C69C6D]/15 overflow-hidden">
                                @foreach($order->orderItems as $item)
                                <div class="flex justify-between items-center px-4 py-3 border-b border-[#C69C6D]/10 last:border-b-0 hover:bg-[#C69C6D]/5 transition">
                                    <div>
                                        <span class="text-[#F5F0E6] font-medium">{{ $item->quantity }}x {{ $item->product->name }}</span>
                                        @if(isset($item->notes) && $item->notes)
                                        <p class="text-xs text-[#C69C6D] mt-0.5">📝 {{ $item->notes }}</p>
                                        @endif
                                    </div>
                                    <span class="text-[#C69C6D] font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        @if($order->notes)
                        <!-- Catatan -->
                        <div class="mb-6">
                            <p class="text-xs font-medium text-[#C69C6D] uppercase tracking-wider mb-2">Catatan Pesanan</p>
                            <div class="bg-[#2E1F1A]/30 rounded-xl px-4 py-3 border border-[#C69C6D]/15">
                                <p class="text-[#F5F0E6] text-sm">📝 {{ $order->notes }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Status Update -->
                        <div class="mb-8">
                            <label for="status" class="block text-xs font-medium text-[#C69C6D] uppercase tracking-wider mb-3">
                                🔄 Update Status Pesanan
                            </label>
                            <select name="status" id="status"
                                    class="w-full px-4 py-3 bg-[#2E1F1A] border-2 border-[#C69C6D]/30 text-[#F5F0E6] rounded-xl focus:outline-none focus:border-[#C69C6D] focus:ring-2 focus:ring-[#C69C6D]/20 transition cursor-pointer font-medium">
                                <option value="pending"   {{ $order->status === 'pending'   ? 'selected' : '' }}>⏳ Menunggu</option>
                                <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>🔥 Sedang Disiapkan</option>
                                <option value="ready"     {{ $order->status === 'ready'     ? 'selected' : '' }}>✅ Siap Diambil</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>✓ Selesai</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>✕ Dibatalkan</option>
                            </select>

                            <!-- Status Preview Badge -->
                            <div class="mt-3 flex items-center gap-2">
                                <span class="text-xs text-[#C69C6D]">Status saat ini:</span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold border
                                    @if($order->status === 'pending')   bg-[#2f261a] text-[#fbbf24] border-[#fbbf24]/30
                                    @elseif($order->status === 'preparing') bg-[#1a2330] text-[#60a5fa] border-[#60a5fa]/30
                                    @elseif($order->status === 'ready') bg-[#1a2f1a] text-[#4ade80] border-[#4ade80]/30
                                    @elseif($order->status === 'completed') bg-[#1a1a1a] text-[#F5F0E6] border-[#F5F0E6]/30
                                    @else bg-[#2f1a1a] text-[#f87171] border-[#f87171]/30
                                    @endif">
                                    @php
                                        $statusLabels = [
                                            'pending'   => '⏳ Menunggu',
                                            'preparing' => '🔥 Disiapkan',
                                            'ready'     => '✅ Siap',
                                            'completed' => '✓ Selesai',
                                            'cancelled' => '✕ Dibatalkan',
                                        ];
                                    @endphp
                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] hover:from-[#D4AF7A] hover:to-[#C69C6D] text-[#121212] font-bold py-3.5 px-6 rounded-xl shadow-lg hover:shadow-[#C69C6D]/40 transform hover:scale-[1.02] transition-all duration-200 text-base">
                                💾 Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.orders.index') }}"
                               class="px-6 py-3.5 bg-[#2E1F1A] border border-[#C69C6D]/30 text-[#C69C6D] font-semibold rounded-xl hover:bg-[#3E2F2A] hover:border-[#C69C6D]/60 transition text-center">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="mt-4 text-center text-xs text-[#C69C6D]/60">
                Dibuat: {{ $order->created_at->format('d/m/Y H:i') }} •
                Diperbarui: {{ $order->updated_at->format('d/m/Y H:i') }}
            </div>
        </div>
    </main>

</body>
</html>
