<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Pesanan - NgopiGo</title>
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom Premium Colors - Same as Landing Page */
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

        /* Gradient Text */
        .gradient-gold {
            background: linear-gradient(135deg, #C69C6D 0%, #F5DEB3 50%, #C69C6D 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Premium Card */
        .premium-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .premium-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(198, 156, 109, 0.2);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--dark-brown);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold-light);
        }
    </style>
</head>
<body class="bg-premium-black text-[#F5F0E6] min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] border-b border-[#C69C6D]/30 shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold gradient-gold">📋 Semua Pesanan</h1>
                    <p class="text-[#C69C6D] mt-1">Riwayat Pesanan NgopiGo</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-white text-sm">
                        <span class="text-[#C69C6D]">Halo,</span>
                        <span class="font-semibold ml-1 text-[#F5F0E6]">{{ auth()->guard('admin')->user()->name }}</span>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-[#C69C6D] hover:bg-[#D4AF7A] text-[#121212] font-semibold py-2 px-4 rounded-lg transition text-sm shadow-lg hover:shadow-[#C69C6D]/50">
                            🚪 Logout
                        </button>
                    </form>
                    <a href="{{ route('admin.products.index') }}"
                       class="bg-[#C69C6D]/20 hover:bg-[#C69C6D]/40 border border-[#C69C6D]/50 text-[#F5F0E6] font-semibold py-2 px-4 rounded-lg transition backdrop-blur-sm">
                        📦 Produk
                    </a>
                    <a href="{{ route('admin.kitchen') }}"
                       class="bg-[#C69C6D]/20 hover:bg-[#C69C6D]/40 border border-[#C69C6D]/50 text-[#F5F0E6] font-semibold py-2 px-4 rounded-lg transition backdrop-blur-sm">
                        👨‍🍳 Dapur
                    </a>
                    <a href="{{ route('order.create') }}"
                       class="bg-[#C69C6D]/20 hover:bg-[#C69C6D]/40 border border-[#C69C6D]/50 text-[#F5F0E6] font-semibold py-2 px-4 rounded-lg transition backdrop-blur-sm">
                        🛒 Ke Website
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @if(session('success'))
        <div class="bg-[#1a2f1a] border border-[#4ade80]/50 text-[#4ade80] px-4 py-3 rounded-lg mb-6 shadow-lg">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-[#1a120f] rounded-xl shadow-xl overflow-hidden border border-[#C69C6D]/20 premium-card">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#C69C6D]/20">
                    <thead class="bg-[#2E1F1A]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Order #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Meja</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Pembayaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-[#1a120f] divide-y divide-[#C69C6D]/10">
                        @forelse($orders as $order)
                        <tr class="hover:bg-[#2E1F1A]/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-[#F5F0E6]">{{ $order->order_number }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-[#F5F0E6] font-medium">🪑 {{ $order->table_number }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <div class="font-medium text-[#F5F0E6]">{{ $order->customer_name }}</div>
                                    <div class="text-[#C69C6D]">📱 {{ $order->phone }}</div>
                                    @if($order->email)
                                    <div class="text-[#C69C6D]">📧 {{ $order->email }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($order->payment_method === 'cod') bg-[#1a2f1a] text-[#4ade80] border border-[#4ade80]/30
                                    @else bg-[#1a2330] text-[#60a5fa] border border-[#60a5fa]/30
                                    @endif">
                                    @if($order->payment_method === 'cod')
                                        💵 COD
                                    @else
                                        💳 Online
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-[#F5F0E6]">
                                    @foreach($order->orderItems->take(2) as $item)
                                    <div>{{ $item->quantity }}x {{ $item->product->name }}</div>
                                    @endforeach
                                    @if($order->orderItems->count() > 2)
                                    <div class="text-[#C69C6D]">+{{ $order->orderItems->count() - 2 }} lainnya</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold gradient-gold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-medium border
                                    @if($order->status === 'pending') bg-[#2f261a] text-[#fbbf24] border-[#fbbf24]/30
                                    @elseif($order->status === 'preparing') bg-[#1a2330] text-[#60a5fa] border-[#60a5fa]/30
                                    @elseif($order->status === 'ready') bg-[#1a2f1a] text-[#4ade80] border-[#4ade80]/30
                                    @elseif($order->status === 'completed') bg-[#1a1a1a] text-[#F5F0E6] border-[#F5F0E6]/30
                                    @else bg-[#2f1a1a] text-[#f87171] border-[#f87171]/30
                                    @endif">
                                    @php
                                        $statusLabels = [
                                            'pending' => 'Menunggu',
                                            'preparing' => 'Disiapkan',
                                            'ready' => 'Siap',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan'
                                        ];
                                    @endphp
                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#C69C6D]">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                                <br>
                                <span class="text-xs text-[#C69C6D]/70">{{ $order->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.orders.edit', $order->id) }}"
                                   class="text-[#60a5fa] hover:text-[#93c5fd] mr-3 transition">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            onclick="if(confirm('Hapus pesanan ini?')) this.closest('form').submit()"
                                            class="text-[#f87171] hover:text-[#fca5a5] transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-[#C69C6D]">
                                📭 Belum ada pesanan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
        @endif
    </main>
</body>
</html>
