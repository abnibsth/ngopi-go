<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NgopiGo</title>
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <h1 class="text-3xl font-bold gradient-gold">🎛️ Dashboard Admin</h1>
                    <p class="text-[#C69C6D] mt-1">Statistik Penjualan NgopiGo</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right text-white">
                        <p class="text-sm text-[#C69C6D]">Halo,</p>
                        <p class="font-semibold text-[#F5F0E6]">{{ auth()->guard('admin')->user()->name }}</p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-[#C69C6D] hover:bg-[#D4AF7A] text-[#121212] font-semibold py-2 px-4 rounded-lg transition shadow-lg hover:shadow-[#C69C6D]/50">
                            🚪 Logout
                        </button>
                    </form>
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
        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Pendapatan -->
            <div class="bg-gradient-to-br from-[#1a2f1a] to-[#0f1f0f] rounded-2xl shadow-xl p-6 text-white border border-[#4ade80]/30 premium-card">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-[#C69C6D] text-sm mb-1">Total Pendapatan</p>
                        <p class="text-3xl font-bold gradient-gold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-5xl opacity-50">💰</div>
                </div>
                <div class="text-[#4ade80] text-xs">
                    📈 {{ $totalOrders }} pesanan selesai
                </div>
            </div>

            <!-- Pesanan Aktif -->
            <div class="bg-gradient-to-br from-[#1a2330] to-[#0f151f] rounded-2xl shadow-xl p-6 text-white border border-[#60a5fa]/30 premium-card">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-[#C69C6D] text-sm mb-1">Pesanan Aktif</p>
                        <p class="text-3xl font-bold text-[#60a5fa]">{{ $pendingOrders }}</p>
                    </div>
                    <div class="text-5xl opacity-50">🔥</div>
                </div>
                <div class="text-[#60a5fa] text-xs">
                    ⏳ Perlu diproses
                </div>
            </div>

            <!-- Produk -->
            <div class="bg-gradient-to-br from-[#2f261a] to-[#1f190f] rounded-2xl shadow-xl p-6 text-white border border-[#fbbf24]/30 premium-card">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-[#C69C6D] text-sm mb-1">Total Produk</p>
                        <p class="text-3xl font-bold text-[#fbbf24]">{{ $activeProducts }}/{{ $totalProducts }}</p>
                    </div>
                    <div class="text-5xl opacity-50">📦</div>
                </div>
                <div class="text-[#fbbf24] text-xs">
                    ✅ Produk tersedia
                </div>
            </div>

            <!-- Admin -->
            <div class="bg-gradient-to-br from-[#2a1a2f] to-[#1a0f1f] rounded-2xl shadow-xl p-6 text-white border border-[#c084fc]/30 premium-card">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-[#C69C6D] text-sm mb-1">Admin Aktif</p>
                        <p class="text-3xl font-bold text-[#c084fc]">{{ $adminCount }}</p>
                    </div>
                    <div class="text-5xl opacity-50">👥</div>
                </div>
                <div class="text-[#c084fc] text-xs">
                    👨‍💼 Tim aktif
                </div>
            </div>
        </div>

        <!-- Period Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Hari Ini -->
            <div class="bg-[#1a120f] rounded-2xl shadow-md p-6 border-l-4 border-[#4ade80] premium-card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-[#F5F0E6] font-semibold">📊 Hari Ini</h3>
                    <span class="text-3xl">🌅</span>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[#C69C6D]">Pesanan</span>
                        <span class="font-bold text-[#F5F0E6]">{{ $todayOrdersCount }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[#C69C6D]">Pendapatan</span>
                        <span class="font-bold text-[#4ade80]">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Minggu Ini -->
            <div class="bg-[#1a120f] rounded-2xl shadow-md p-6 border-l-4 border-[#60a5fa] premium-card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-[#F5F0E6] font-semibold">📊 Minggu Ini</h3>
                    <span class="text-3xl">📅</span>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[#C69C6D]">Pesanan</span>
                        <span class="font-bold text-[#F5F0E6]">{{ $weekOrders }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[#C69C6D]">Pendapatan</span>
                        <span class="font-bold text-[#60a5fa]">Rp {{ number_format($weekRevenue, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Bulan Ini -->
            <div class="bg-[#1a120f] rounded-2xl shadow-md p-6 border-l-4 border-[#c084fc] premium-card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-[#F5F0E6] font-semibold">📊 Bulan Ini</h3>
                    <span class="text-3xl">🗓️</span>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[#C69C6D]">Pesanan</span>
                        <span class="font-bold text-[#F5F0E6]">{{ $monthOrders }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[#C69C6D]">Pendapatan</span>
                        <span class="font-bold text-[#c084fc]">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Top Products -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Sales Chart -->
            <div class="bg-[#1a120f] rounded-2xl shadow-md p-6 lg:col-span-2 border border-[#C69C6D]/20">
                <h3 class="text-xl font-bold text-[#F5F0E6] mb-4">📈 Grafik Penjualan 7 Hari Terakhir</h3>
                <canvas id="salesChart" height="100"></canvas>
            </div>

            <!-- Top Products -->
            <div class="bg-[#1a120f] rounded-2xl shadow-md p-6 border border-[#C69C6D]/20">
                <h3 class="text-xl font-bold text-[#F5F0E6] mb-4">🏆 Top 5 Produk Terlaris</h3>
                <div class="space-y-4">
                    @forelse($topProducts as $index => $product)
                    <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-[#2E1F1A]/50 transition">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#C69C6D] to-[#D4AF7A] flex items-center justify-center text-[#121212] font-bold text-sm">
                            {{ $index + 1 }}
                        </div>
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-12 h-12 object-cover rounded-lg">
                        @else
                        <div class="w-12 h-12 bg-[#2E1F1A] rounded-lg flex items-center justify-center">
                            <span class="text-xl">📷</span>
                        </div>
                        @endif
                        <div class="flex-1">
                            <p class="font-semibold text-[#F5F0E6] text-sm">{{ $product->name }}</p>
                            <p class="text-xs text-[#C69C6D]">{{ $product->total_sold }} terjual</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-[#C69C6D] text-center py-8">Belum ada data penjualan</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Status & Payment Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Orders by Status -->
            <div class="bg-[#1a120f] rounded-2xl shadow-md p-6 border border-[#C69C6D]/20">
                <h3 class="text-xl font-bold text-[#F5F0E6] mb-4">📊 Status Pesanan</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-[#2f261a] rounded-xl p-4 border-2 border-[#fbbf24]/30">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-2xl">⏳</span>
                            <span class="text-3xl font-bold text-[#fbbf24]">{{ $ordersByStatus['pending'] ?? 0 }}</span>
                        </div>
                        <p class="text-sm text-[#C69C6D]">Menunggu</p>
                    </div>
                    <div class="bg-[#1a2330] rounded-xl p-4 border-2 border-[#60a5fa]/30">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-2xl">🔥</span>
                            <span class="text-3xl font-bold text-[#60a5fa]">{{ $ordersByStatus['preparing'] ?? 0 }}</span>
                        </div>
                        <p class="text-sm text-[#C69C6D]">Disiapkan</p>
                    </div>
                    <div class="bg-[#1a2f1a] rounded-xl p-4 border-2 border-[#4ade80]/30">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-2xl">✅</span>
                            <span class="text-3xl font-bold text-[#4ade80]">{{ $ordersByStatus['ready'] ?? 0 }}</span>
                        </div>
                        <p class="text-sm text-[#C69C6D]">Siap</p>
                    </div>
                    <div class="bg-[#1a1a1a] rounded-xl p-4 border-2 border-[#F5F0E6]/30">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-2xl">✓</span>
                            <span class="text-3xl font-bold text-[#F5F0E6]">{{ $ordersByStatus['completed'] ?? 0 }}</span>
                        </div>
                        <p class="text-sm text-[#C69C6D]">Selesai</p>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-[#1a120f] rounded-2xl shadow-md p-6 border border-[#C69C6D]/20">
                <h3 class="text-xl font-bold text-[#F5F0E6] mb-4">💳 Metode Pembayaran</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-[#1a2f1a] to-[#0f1f0f] rounded-xl p-4 border-2 border-[#4ade80]/30">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-2xl">💵</span>
                            <span class="text-3xl font-bold text-[#4ade80]">{{ $paymentsByMethod['cod'] ?? 0 }}</span>
                        </div>
                        <p class="text-sm text-[#C69C6D]">COD (Di Tempat)</p>
                    </div>
                    <div class="bg-gradient-to-br from-[#1a2330] to-[#0f151f] rounded-xl p-4 border-2 border-[#60a5fa]/30">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-2xl">💳</span>
                            <span class="text-3xl font-bold text-[#60a5fa]">{{ $paymentsByMethod['online'] ?? 0 }}</span>
                        </div>
                        <p class="text-sm text-[#C69C6D]">Online Transfer</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-[#1a120f] rounded-2xl shadow-md p-6 mb-8 border border-[#C69C6D]/20">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-[#F5F0E6]">📋 Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-[#C69C6D] hover:text-[#D4AF7A] text-sm font-semibold transition">
                    Lihat Semua →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-[#2E1F1A]">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase">Order #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase">Meja</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase">Items</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#C69C6D]/10">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-[#2E1F1A]/50 transition">
                            <td class="px-4 py-3 text-sm font-semibold text-[#F5F0E6]">{{ $order->order_number }}</td>
                            <td class="px-4 py-3 text-sm">
                                <div>
                                    <p class="font-medium text-[#F5F0E6]">{{ $order->customer_name }}</p>
                                    <p class="text-xs text-[#C69C6D]">📱 {{ $order->phone }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-[#F5F0E6]">🪑 {{ $order->table_number }}</td>
                            <td class="px-4 py-3 text-sm text-[#C69C6D]">{{ $order->orderItems->count() }} item</td>
                            <td class="px-4 py-3 text-sm font-bold gradient-gold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-medium border
                                    @if($order->status === 'pending') bg-[#2f261a] text-[#fbbf24] border-[#fbbf24]/30
                                    @elseif($order->status === 'preparing') bg-[#1a2330] text-[#60a5fa] border-[#60a5fa]/30
                                    @elseif($order->status === 'ready') bg-[#1a2f1a] text-[#4ade80] border-[#4ade80]/30
                                    @elseif($order->status === 'completed') bg-[#1a1a1a] text-[#F5F0E6] border-[#F5F0E6]/30
                                    @else bg-[#2f1a1a] text-[#f87171] border-[#f87171]/30
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-[#C69C6D]">
                                📭 Belum ada pesanan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('admin.kitchen') }}"
               class="bg-gradient-to-br from-[#1a2330] to-[#0f151f] hover:from-[#1f2d3d] hover:to-[#141f2f] rounded-2xl shadow-lg p-6 text-white border border-[#60a5fa]/30 transform hover:scale-105 transition-all">
                <div class="text-4xl mb-3">👨‍🍳</div>
                <h4 class="text-lg font-bold mb-1 text-[#60a5fa]">Kelola Dapur</h4>
                <p class="text-[#C69C6D] text-sm">Update status pesanan</p>
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="bg-gradient-to-br from-[#1a2f1a] to-[#0f1f0f] hover:from-[#1f3d1f] hover:to-[#142f14] rounded-2xl shadow-lg p-6 text-white border border-[#4ade80]/30 transform hover:scale-105 transition-all">
                <div class="text-4xl mb-3">📦</div>
                <h4 class="text-lg font-bold mb-1 text-[#4ade80]">Kelola Produk</h4>
                <p class="text-[#C69C6D] text-sm">Tambah/edit menu</p>
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="bg-gradient-to-br from-[#2a1a2f] to-[#1a0f1f] hover:from-[#3d1f3f] hover:to-[#2f142f] rounded-2xl shadow-lg p-6 text-white border border-[#c084fc]/30 transform hover:scale-105 transition-all">
                <div class="text-4xl mb-3">📋</div>
                <h4 class="text-lg font-bold mb-1 text-[#c084fc]">Riwayat Pesanan</h4>
                <p class="text-[#C69C6D] text-sm">Lihat semua pesanan</p>
            </a>
        </div>
    </main>

    <script>
        // Sales Chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesData = @json($salesChart);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: salesData.map(item => item.date),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: salesData.map(item => item.revenue),
                    borderColor: '#C69C6D',
                    backgroundColor: 'rgba(198, 156, 109, 0.1)',
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#F5F0E6'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#C69C6D',
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        ticks: {
                            color: '#C69C6D'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
