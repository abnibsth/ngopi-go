<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dapur - NgopiGo</title>
        <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">👨‍🍳 Dapur NgopiGo</h1>
                    <p class="text-blue-100 mt-1">Kelola Pesanan</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-white text-sm">
                        <span class="text-gray-300">Halo,</span>
                        <span class="font-semibold ml-1">{{ auth()->guard('admin')->user()->name }}</span>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition text-sm">
                            🚪 Logout
                        </button>
                    </form>
                    <a href="{{ route('admin.products.index') }}" 
                       class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-semibold py-2 px-4 rounded-lg transition">
                        📦 Produk
                    </a>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-semibold py-2 px-4 rounded-lg transition">
                        📋 Semua Pesanan
                    </a>
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
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                <p class="text-gray-500 text-sm mb-1">Menunggu</p>
                <p class="text-3xl font-bold text-gray-800">{{ $orders->where('status', 'pending')->count() }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <p class="text-gray-500 text-sm mb-1">Disiapkan</p>
                <p class="text-3xl font-bold text-gray-800">{{ $orders->where('status', 'preparing')->count() }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <p class="text-gray-500 text-sm mb-1">Siap</p>
                <p class="text-3xl font-bold text-gray-800">{{ $orders->where('status', 'ready')->count() }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-gray-500">
                <p class="text-gray-500 text-sm mb-1">Selesai</p>
                <p class="text-3xl font-bold text-gray-800">{{ $orders->where('status', 'completed')->count() }}</p>
            </div>
        </div>

        <!-- Orders Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($orders as $order)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="text-xs text-gray-500">Order #{{ $order->order_number }}</p>
                            <p class="text-lg font-bold text-gray-800">🪑 Meja {{ $order->table_number }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'preparing') bg-blue-100 text-blue-800
                            @elseif($order->status === 'ready') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
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
                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-2">
                        <span>👤 {{ $order->customer_name }}</span>
                        <span>📱 {{ $order->phone }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs">
                        <span class="px-2 py-1 rounded bg-amber-100 text-amber-800 font-medium">
                            @if($order->payment_method === 'cod')
                                💵 COD
                            @else
                                💳 Online
                            @endif
                        </span>
                        <span class="text-gray-500">🕐 {{ $order->created_at->diffForHumans() }}</span>
                    </div>
                    @if($order->email)
                    <p class="text-xs text-gray-500 mt-1">📧 {{ $order->email }}</p>
                    @endif
                </div>

                <!-- Order Items -->
                <div class="p-6">
                    <ul class="space-y-3">
                        @foreach($order->orderItems as $item)
                        <li class="flex items-start gap-3">
                            <span class="bg-amber-100 text-amber-800 font-bold text-sm px-2 py-1 rounded">
                                {{ $item->quantity }}x
                            </span>
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">{{ $item->product->name }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    @if($order->notes)
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-xs text-gray-500">📋 Catatan: {{ $order->notes }}</p>
                    </div>
                    @endif
                </div>

                <!-- Card Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-gray-600">Total</span>
                        <span class="text-lg font-bold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex gap-2">
                            @if($order->status === 'pending')
                            <button type="submit" name="status" value="preparing" 
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                                🔥 Siapkan
                            </button>
                            @elseif($order->status === 'preparing')
                            <button type="submit" name="status" value="ready" 
                                    class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                                ✅ Siap Saji
                            </button>
                            @elseif($order->status === 'ready')
                            <button type="submit" name="status" value="completed" 
                                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                                ✓ Selesai
                            </button>
                            @endif
                            <button type="button" 
                                    onclick="if(confirm('Hapus pesanan ini?')) document.getElementById('delete-form-{{ $order->id }}').submit()"
                                    class="bg-red-100 hover:bg-red-200 text-red-600 font-semibold py-2 px-4 rounded-lg transition">
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
                <p class="text-gray-500 text-lg">🎉 Tidak ada pesanan aktif</p>
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
