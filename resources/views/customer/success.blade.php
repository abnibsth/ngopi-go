<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - NgopiGo</title>
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-amber-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-2xl w-full">
        <!-- Success Icon -->
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">Pesanan Berhasil!</h1>
        <p class="text-gray-600 mb-6 text-center">Terima kasih telah memesan di NgopiGo</p>

        <!-- Order Info -->
        <div class="bg-amber-50 rounded-xl p-6 mb-6">
            <!-- Queue Number & Order Number -->
            <div class="text-center mb-6 pb-6 border-b-2 border-amber-200">
                <p class="text-sm text-gray-600 mb-1">Nomor Antrian</p>
                <p class="text-5xl font-bold text-amber-600 mb-2">#{{ $order->getFormattedQueueNumber() }}</p>
                <div class="flex items-center justify-center gap-2">
                    <span class="text-sm text-gray-600">No. Pesanan:</span>
                    <span class="text-lg font-bold text-amber-600">{{ $order->getFormattedOrderNumber() }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-600">Meja</p>
                    <p class="text-lg font-semibold text-gray-800">🪑 {{ $order->table_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <p class="text-lg font-semibold">
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'preparing') bg-blue-100 text-blue-800
                            @elseif($order->status === 'ready') bg-green-100 text-green-800
                            @elseif($order->status === 'completed') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800
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
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Pembayaran</p>
                    <p class="text-lg font-semibold">
                        @if($order->payment_method === 'cod')
                            💵 COD (Di Tempat)
                        @else
                            💳 Online
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Waktu</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $order->created_at->format('H:i') }}</p>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="border-t-2 border-amber-200 pt-4 mb-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nama</p>
                        <p class="font-medium text-gray-800">👤 {{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">WhatsApp</p>
                        <p class="font-medium text-gray-800">📱 {{ $order->phone }}</p>
                    </div>
                    @if($order->email)
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-medium text-gray-800">📧 {{ $order->email }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="border-t-2 border-amber-200 pt-4">
                <p class="text-sm text-gray-600 mb-3">Detail Pesanan</p>
                <div class="space-y-2">
                    @foreach($order->orderItems as $item)
                    <div class="flex justify-between items-center text-sm">
                        <div>
                            <span class="text-xs text-gray-500 font-mono">{{ $order->getProductCode($item) }}</span>
                            <span class="text-gray-700 ml-2">{{ $item->quantity }}x {{ $item->product->name }}</span>
                        </div>
                        <span class="text-gray-800 font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center mt-4 pt-4 border-t-2 border-amber-200">
                    <span class="text-lg font-bold text-gray-800">Total Bayar</span>
                    <span class="text-2xl font-bold text-amber-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        @if($order->notes)
        <div class="bg-gray-50 rounded-lg p-3 mb-6">
            <p class="text-xs text-gray-500 mb-1">📝 Catatan:</p>
            <p class="text-sm text-gray-700">{{ $order->notes }}</p>
        </div>
        @endif

        <div class="text-center mb-6">
            <p class="text-sm text-gray-600">
                Pesanan Anda sedang disiapkan. Silahkan tunggu di meja <strong>{{ $order->table_number }}</strong>
            </p>
            @if($order->payment_method === 'online')
            <p class="text-xs text-orange-600 mt-2">
                ⚠️ Untuk pembayaran online, silahkan transfer ke rekening yang akan ditampilkan ke kasir.
            </p>
            @endif
        </div>

        <div class="flex gap-3">
            <a href="{{ route('order.create', $order->table_number) }}"
               class="flex-1 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200 text-center">
                🛒 Pesan Lagi
            </a>
            <a href="{{ route('order.success', $order->order_number) }}"
               class="px-6 py-3 border-2 border-amber-300 text-amber-700 font-semibold rounded-xl hover:bg-amber-50 transition text-center">
                🔄 Refresh
            </a>
        </div>
    </div>
</body>
</html>
