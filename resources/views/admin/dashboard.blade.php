<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NgopiGo</title>
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    
    <!-- Header -->
    <header class="bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">🎛️ Dashboard Admin</h1>
                    <p class="text-purple-100 mt-1">Statistik Penjualan NgopiGo</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right text-white">
                        <p class="text-sm text-gray-300">Halo,</p>
                        <p class="font-semibold">{{ auth()->guard('admin')->user()->name }}</p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                            🚪 Logout
                        </button>
                    </form>
                    <a href="{{ route('order.create') }}" 
                       class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-semibold py-2 px-4 rounded-lg transition">
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
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-green-100 text-sm mb-1">Total Pendapatan</p>
                        <p class="text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-5xl opacity-50">💰</div>
                </div>
                <div class="text-green-100 text-xs">
                    📈 {{ $totalOrders }} pesanan selesai
                </div>
            </div>

            <!-- Pesanan Aktif -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-blue-100 text-sm mb-1">Pesanan Aktif</p>
                        <p class="text-3xl font-bold">{{ $pendingOrders }}</p>
                    </div>
                    <div class="text-5xl opacity-50">🔥</div>
                </div>
                <div class="text-blue-100 text-xs">
                    ⏳ Perlu diproses
                </div>
            </div>

            <!-- Produk -->
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-amber-100 text-sm mb-1">Total Produk</p>
                        <p class="text-3xl font-bold">{{ $activeProducts }}/{{ $totalProducts }}</p>
                    </div>
                    <div class="text-5xl opacity-50">📦</div>
                </div>
                <div class="text-amber-100 text-xs">
                    ✅ Produk tersedia
                </div>
            </div>

            <!-- Admin -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-purple-100 text-sm mb-1">Admin Aktif</p>
                        <p class="text-3xl font-bold">{{ $adminCount }}</p>
                    </div>
                    <div class="text-5xl opacity-50">👥</div>
                </div>
                <div class="text-purple-100 text-xs">
                    👨‍💼 Tim aktif
                </div>
            </div>
        </div>

        <!-- Period Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Hari Ini -->
            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-600 font-semibold">📊 Hari Ini</h3>
                    <span class="text-3xl">🌅</span>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Pesanan</span>
                        <span class="font-bold text-gray-800">{{ $todayOrdersCount }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Pendapatan</span>
                        <span class="font-bold text-green-600">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Minggu Ini -->
            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-600 font-semibold">📊 Minggu Ini</h3>
                    <span class="text-3xl">📅</span>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Pesanan</span>
                        <span class="font-bold text-gray-800">{{ $weekOrders }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Pendapatan</span>
                        <span class="font-bold text-blue-600">Rp {{ number_format($weekRevenue, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Bulan Ini -->
            <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-600 font-semibold">📊 Bulan Ini</h3>
                    <span class="text-3xl">🗓️</span>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Pesanan</span>
                        <span class="font-bold text-gray-800">{{ $monthOrders }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Pendapatan</span>
                        <span class="font-bold text-purple-600">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Top Products -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Sales Chart -->
            <div class="bg-white rounded-2xl shadow-md p-6 lg:col-span-2">
                <h3 class="text-xl font-bold text-gray-800 mb-4">📈 Grafik Penjualan 7 Hari Terakhir</h3>
                <canvas id="salesChart" height="100"></canvas>
            </div>

            <!-- Top Products -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">🏆 Top 5 Produk Terlaris</h3>
                <div class="space-y-4">
                    @forelse($topProducts as $index => $product)
                    <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white font-bold text-sm">
                            {{ $index + 1 }}
                        </div>
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-12 h-12 object-cover rounded-lg">
                        @else
                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-xl">📷</span>
                        </div>
                        @endif
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800 text-sm">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">{{ $product->total_sold }} terjual</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-8">Belum ada data penjualan</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Status & Payment Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Orders by Status -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">📊 Status Pesanan</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-yellow-50 rounded-xl p-4 border-2 border-yellow-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-2xl">⏳</span>
                            <span class="text-3xl font-bold text-yellow-600">{{ $ordersByStatus['pending'] ?? 0 }}</span>
                        </div>
                        <p class="text-sm text-gray-600">Menunggu</p>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-4 border-2 border-blue-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-2xl">🔥</span>
                            <span class="text-3xl font-bold text-blue-600">{{ $ordersByStatus['preparing'] ?? 0 }}</span>
                        </div>
                        <p class="text-sm text-gray-600">Disiapkan</p>
                    </div>
                    <div class="bg-green-50 rounded-xl p-4 border-2 border-green-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-2xl">✅</span>
                            <span class="text-3xl font-bold text-green-600">{{ $ordersByStatus['ready'] ?? 0 }}</span>
                        </div>
                        <p class="text-sm text-gray-600">Siap</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-2xl">✓</span>
                            <span class="text-3xl font-bold text-gray-600">{{ $ordersByStatus['completed'] ?? 0 }}</span>
                        </div>
                        <p class="text-sm text-gray-600">Selesai</p>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">💳 Metode Pembayaran</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border-2 border-green-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-2xl">💵</span>
                            <span class="text-3xl font-bold text-green-600">{{ $paymentsByMethod['cod'] ?? 0 }}</span>
                        </div>
                        <p class="text-sm text-gray-600">COD (Di Tempat)</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border-2 border-blue-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-2xl">💳</span>
                            <span class="text-3xl font-bold text-blue-600">{{ $paymentsByMethod['online'] ?? 0 }}</span>
                        </div>
                        <p class="text-sm text-gray-600">Online Transfer</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">📋 Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-semibold">
                    Lihat Semua →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Meja</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-sm font-semibold text-gray-800">{{ $order->order_number }}</td>
                            <td class="px-4 py-3 text-sm">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $order->customer_name }}</p>
                                    <p class="text-xs text-gray-500">📱 {{ $order->phone }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800">🪑 {{ $order->table_number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $order->orderItems->count() }} item</td>
                            <td class="px-4 py-3 text-sm font-bold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'preparing') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'ready') bg-green-100 text-green-800
                                    @elseif($order->status === 'completed') bg-gray-100 text-gray-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
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
               class="bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all">
                <div class="text-4xl mb-3">👨‍🍳</div>
                <h4 class="text-lg font-bold mb-1">Kelola Dapur</h4>
                <p class="text-blue-100 text-sm">Update status pesanan</p>
            </a>

            <a href="{{ route('admin.products.index') }}" 
               class="bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all">
                <div class="text-4xl mb-3">📦</div>
                <h4 class="text-lg font-bold mb-1">Kelola Produk</h4>
                <p class="text-green-100 text-sm">Tambah/edit menu</p>
            </a>

            <a href="{{ route('admin.orders.index') }}" 
               class="bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all">
                <div class="text-4xl mb-3">📋</div>
                <h4 class="text-lg font-bold mb-1">Riwayat Pesanan</h4>
                <p class="text-purple-100 text-sm">Lihat semua pesanan</p>
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
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
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
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
