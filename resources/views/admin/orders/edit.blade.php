<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pesanan - NgopiGo</title>
        <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">✏️ Edit Pesanan</h1>
                    <p class="text-purple-100 mt-1">{{ $order->order_number }}</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" 
                   class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-semibold py-2 px-4 rounded-lg transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-md p-8">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Order Info -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Order</label>
                            <p class="text-lg font-semibold text-gray-800">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Meja</label>
                            <p class="text-lg font-semibold text-gray-800">{{ $order->table_number }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Pelanggan</label>
                            <p class="text-lg font-semibold text-gray-800">{{ $order->customer_name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Total</label>
                            <p class="text-lg font-bold text-amber-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Item Pesanan</label>
                        <div class="space-y-2">
                            @foreach($order->orderItems as $item)
                            <div class="flex justify-between items-center py-2 border-b">
                                <span class="text-gray-800">{{ $item->quantity }}x {{ $item->product->name }}</span>
                                <span class="text-gray-800 font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                            @if($item->notes)
                            <p class="text-xs text-gray-500 pl-4">📝 {{ $item->notes }}</p>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    @if($order->notes)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Catatan Order</label>
                        <p class="text-gray-800">{{ $order->notes }}</p>
                    </div>
                    @endif

                    <!-- Status Update -->
                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                        <select name="status" id="status" 
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                            <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>🔥 Disiapkan</option>
                            <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>✅ Siap</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>✓ Selesai</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>✕ Dibatalkan</option>
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                            💾 Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.orders.index') }}" 
                           class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
