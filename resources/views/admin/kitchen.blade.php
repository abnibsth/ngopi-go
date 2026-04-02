<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dapur - NgopiGo</title>
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
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(198, 156, 109, 0.2);
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
                    <h1 class="text-3xl font-bold gradient-gold">👨‍🍳 Dapur NgopiGo</h1>
                    <p class="text-[#C69C6D] mt-1">Kelola Pesanan</p>
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
                    <a href="{{ route('admin.orders.index') }}"
                       class="bg-[#C69C6D]/20 hover:bg-[#C69C6D]/40 border border-[#C69C6D]/50 text-[#F5F0E6] font-semibold py-2 px-4 rounded-lg transition backdrop-blur-sm">
                        📋 Semua Pesanan
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

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-[#1a120f] rounded-xl shadow-md p-6 border-l-4 border-[#fbbf24] border border-[#C69C6D]/20">
                <p class="text-[#C69C6D] text-sm mb-1">Menunggu</p>
                <p class="text-3xl font-bold text-[#fbbf24]">{{ $orders->where('status', 'pending')->count() }}</p>
            </div>
            <div class="bg-[#1a120f] rounded-xl shadow-md p-6 border-l-4 border-[#60a5fa] border border-[#C69C6D]/20">
                <p class="text-[#C69C6D] text-sm mb-1">Disiapkan</p>
                <p class="text-3xl font-bold text-[#60a5fa]">{{ $orders->where('status', 'preparing')->count() }}</p>
            </div>
            <div class="bg-[#1a120f] rounded-xl shadow-md p-6 border-l-4 border-[#4ade80] border border-[#C69C6D]/20">
                <p class="text-[#C69C6D] text-sm mb-1">Siap</p>
                <p class="text-3xl font-bold text-[#4ade80]">{{ $orders->where('status', 'ready')->count() }}</p>
            </div>
            <div class="bg-[#1a120f] rounded-xl shadow-md p-6 border-l-4 border-[#F5F0E6] border border-[#C69C6D]/20">
                <p class="text-[#C69C6D] text-sm mb-1">Selesai</p>
                <p class="text-3xl font-bold text-[#F5F0E6]">{{ $orders->where('status', 'completed')->count() }}</p>
            </div>
        </div>

        <!-- Orders Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($orders as $order)
            <div class="bg-[#1a120f] rounded-xl shadow-xl overflow-hidden border border-[#C69C6D]/20 premium-card">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] px-6 py-4 border-b border-[#C69C6D]/20">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="text-xs text-[#C69C6D]">Order #{{ $order->order_number }}</p>
                            <p class="text-lg font-bold text-[#F5F0E6]">🪑 Meja {{ $order->table_number }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium border
                            @if($order->status === 'pending') bg-[#2f261a] text-[#fbbf24] border-[#fbbf24]/30
                            @elseif($order->status === 'preparing') bg-[#1a2330] text-[#60a5fa] border-[#60a5fa]/30
                            @elseif($order->status === 'ready') bg-[#1a2f1a] text-[#4ade80] border-[#4ade80]/30
                            @else bg-[#1a1a1a] text-[#F5F0E6] border-[#F5F0E6]/30
                            @endif">
                            @php
                                $statusLabels = [
                                    'pending' => '⏳ Menunggu',
                                    'preparing' => '🔥 Disiapkan',
                                    'ready' => '✅ Siap',
                                    'completed' => '✓ Selesai',
                                    'cancelled' => '✕ Batal'
                                ];
                            @endphp
                            {{ $statusLabels[$order->status] ?? $order->status }}
                        </span>
                    </div>
                    <div class="flex items-center gap-4 text-sm text-[#C69C6D] mb-2">
                        <span>👤 {{ $order->customer_name }}</span>
                        <span>📱 {{ $order->phone }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs">
                        <span class="px-2 py-1 rounded bg-[#2f261a] text-[#fbbf24] font-medium border border-[#fbbf24]/30">
                            @if($order->payment_method === 'cod')
                                💵 COD
                            @else
                                💳 Online
                            @endif
                        </span>
                        <span class="text-[#C69C6D]">🕐 {{ $order->created_at->diffForHumans() }}</span>
                    </div>
                    @if($order->email)
                    <p class="text-xs text-[#C69C6D] mt-1">📧 {{ $order->email }}</p>
                    @endif
                </div>

                <!-- Order Items -->
                <div class="p-6">
                    <ul class="space-y-3">
                        @foreach($order->orderItems as $item)
                        <li class="flex items-start gap-3">
                            <span class="bg-[#2f261a] text-[#fbbf24] font-bold text-sm px-2 py-1 rounded border border-[#fbbf24]/30">
                                {{ $item->quantity }}x
                            </span>
                            <div class="flex-1">
                                <p class="font-medium text-[#F5F0E6]">{{ $item->product->name }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    @if($order->notes)
                    <div class="mt-4 pt-4 border-t border-[#C69C6D]/20">
                        <p class="text-xs text-[#C69C6D]">📋 Catatan: {{ $order->notes }}</p>
                    </div>
                    @endif
                </div>

                <!-- Card Footer -->
                <div class="px-6 py-4 bg-[#2E1F1A]/50 border-t border-[#C69C6D]/20">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-[#C69C6D]">Total</span>
                        <span class="text-lg font-bold gradient-gold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex gap-2">
                            @if($order->status === 'pending')
                            <button type="submit" name="status" value="preparing"
                                    class="flex-1 bg-[#1a2330] hover:bg-[#233040] text-[#60a5fa] font-semibold py-2 px-4 rounded-lg transition border border-[#60a5fa]/30">
                                🔥 Siapkan
                            </button>
                            @elseif($order->status === 'preparing')
                            <button type="submit" name="status" value="ready"
                                    class="flex-1 bg-[#1a2f1a] hover:bg-[#23301f] text-[#4ade80] font-semibold py-2 px-4 rounded-lg transition border border-[#4ade80]/30">
                                ✅ Siap Saji
                            </button>
                            @elseif($order->status === 'ready')
                            <button type="submit" name="status" value="completed"
                                    class="flex-1 bg-[#1a1a1a] hover:bg-[#2a2a2a] text-[#F5F0E6] font-semibold py-2 px-4 rounded-lg transition border border-[#F5F0E6]/30">
                                ✓ Selesai
                            </button>
                            @endif
                            <button type="button"
                                    onclick="if(confirm('Hapus pesanan ini?')) document.getElementById('delete-form-{{ $order->id }}').submit()"
                                    class="bg-[#2f1a1a] hover:bg-[#3f1f1f] text-[#f87171] font-semibold py-2 px-4 rounded-lg transition border border-[#f87171]/30">
                                🗑️
                            </button>
                        </div>
                    </form>
                    <form id="delete-form-{{ $order->id }}" action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-[#C69C6D] text-lg">🎉 Tidak ada pesanan aktif</p>
            </div>
            @endforelse
        </div>
    </main>

    <!-- Auto refresh every 30 seconds -->
    <script>
        setTimeout(() => {
            window.location.reload();
        }, 30000);
    </script>
</body>
</html>
