<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - NgopiGo</title>
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- QRCode.js library -->
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <style>
        @@keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
            50% { box-shadow: 0 0 0 12px rgba(245, 158, 11, 0); }
        }
        .qr-pulse {
            animation: pulse-glow 2s ease-in-out infinite;
        }
        @@keyframes scan-line {
            0% { top: 0; }
            50% { top: calc(100% - 3px); }
            100% { top: 0; }
        }
        .scan-line {
            position: absolute;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, #f59e0b, transparent);
            animation: scan-line 2s ease-in-out infinite;
            box-shadow: 0 0 8px rgba(245, 158, 11, 0.8);
        }
        @@keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="bg-amber-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-xl p-8 max-w-2xl w-full aspect-auto">
        <!-- Success Icon -->
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">Pesanan Berhasil!</h1>
        <p class="text-gray-600 mb-6 text-center">Terima kasih telah memesan di NgopiGo</p>

        <!-- Order Info -->
        <div class="bg-amber-50 rounded-3xl p-6 mb-6">
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
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mb-4">
                    @foreach($order->orderItems as $item)
                    <div class="bg-white rounded-xl p-3 shadow-md border border-amber-100 aspect-square flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-1 mb-2">
                                <span class="text-xs text-gray-500 font-mono bg-gray-100 px-2 py-0.5 rounded text-[10px]">{{ $order->getProductCode($item) }}</span>
                            </div>
                            @if($item->product->image)
                            <div class="w-full aspect-video mb-2 rounded-lg overflow-hidden bg-gray-100">
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            </div>
                            @endif
                            <p class="text-xs font-semibold text-gray-800 mb-1 truncate leading-tight">{{ $item->product->name }}</p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-xs bg-amber-100 text-amber-700 font-bold px-2 py-0.5 rounded">{{ $item->quantity }}x</span>
                            <span class="text-xs font-medium text-gray-700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
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
        <div class="bg-gray-50 rounded-3xl p-3 mb-6">
            <p class="text-xs text-gray-500 mb-1">📝 Catatan:</p>
            <p class="text-sm text-gray-700">{{ $order->notes }}</p>
        </div>
        @endif

        {{-- Weather-Based Recommendation Section with Real Weather --}}
        @php
            // Get available products from database
            $availableProducts = \App\Models\Product::where('is_available', true)
                ->inRandomOrder()
                ->limit(6)
                ->get();
            
            // Weather-based recommendation logic
            $hour = now()->hour;
            $seasonalRecs = [
                'pagi' => [
                    'title' => 'Rekomendasi Pagi ☀️',
                    'description' => 'Mulai harimu dengan semangat!',
                    'gradient' => 'from-orange-50 to-amber-50',
                    'border' => 'border-orange-300',
                    'badge' => 'bg-orange-100 text-orange-700',
                    'icon' => '🌅'
                ],
                'siang' => [
                    'title' => 'Rekomendasi Siang 🔥',
                    'description' => 'Segarkan harimu yang panas!',
                    'gradient' => 'from-yellow-50 to-orange-50',
                    'border' => 'border-yellow-300',
                    'badge' => 'bg-yellow-100 text-yellow-700',
                    'icon' => '☀️'
                ],
                'sore' => [
                    'title' => 'Rekomendasi Sore 🌤️',
                    'description' => 'Nikmati sore yang santai!',
                    'gradient' => 'from-amber-100 to-orange-100',
                    'border' => 'border-amber-300',
                    'badge' => 'bg-amber-100 text-amber-700',
                    'icon' => '🌤️'
                ],
                'malam' => [
                    'title' => 'Rekomendasi Malam 🌙',
                    'description' => 'Hangatkan malammu!',
                    'gradient' => 'from-indigo-50 to-purple-50',
                    'border' => 'border-indigo-300',
                    'badge' => 'bg-indigo-100 text-indigo-700',
                    'icon' => '🌙'
                ]
            ];
            
            // Determine time of day
            if ($hour >= 5 && $hour < 11) {
                $weatherKey = 'pagi';
            } elseif ($hour >= 11 && $hour < 15) {
                $weatherKey = 'siang';
            } elseif ($hour >= 15 && $hour < 18) {
                $weatherKey = 'sore';
            } else {
                $weatherKey = 'malam';
            }
            
            $weatherRec = $seasonalRecs[$weatherKey];
        @endphp

        <div class="fade-in bg-gradient-to-br {{ $weatherRec['gradient'] }} border-2 {{ $weatherRec['border'] }} rounded-3xl p-5 mb-6">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-4xl">{{ $weatherRec['icon'] }}</span>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $weatherRec['title'] }}</h3>
                    <p class="text-xs text-gray-600">{{ $weatherRec['description'] }}</p>
                </div>
                <span class="ml-auto text-xs font-semibold px-3 py-1 rounded-full {{ $weatherRec['badge'] }}">
                    💡 Rekomendasi untuk {{ strtolower(str_replace('Rekomendasi ', '', $weatherRec['title'])) }}
                </span>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                @foreach($availableProducts as $product)
                <div class="bg-white rounded-2xl p-2 shadow-md border border-gray-100 hover:shadow-lg transition-all cursor-pointer group">
                    <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 mb-2">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-3xl text-gray-300">
                            ☕
                        </div>
                        @endif
                    </div>
                    <p class="text-xs font-semibold text-gray-800 truncate text-center">{{ $product->name }}</p>
                    <p class="text-xs text-amber-600 font-bold text-center mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- QR Code Section untuk COD yang belum dibayar --}}
        @if($order->payment_method === 'cod' && $order->payment_status !== 'paid')
        <div class="fade-in" style="animation-delay: 0.3s; opacity: 0;">
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 border-2 border-amber-300 rounded-3xl p-6 mb-6">
                <div class="text-center mb-4">
                    <div class="inline-flex items-center gap-2 bg-amber-100 text-amber-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        Bayar di Kasir
                    </div>
                    <h2 class="text-lg font-bold text-amber-900 mb-1">Scan QR Code Ini ke Kasir</h2>
                    <p class="text-sm text-amber-700">Tunjukkan QR code ini ke kasir untuk memproses pembayaran tunai Anda</p>
                </div>

                <!-- QR Code Box -->
                <div class="flex justify-center mb-4">
                    <div class="relative">
                        <!-- Corner decorations -->
                        <div class="absolute -top-2 -left-2 w-6 h-6 border-t-4 border-l-4 border-amber-500 rounded-tl-lg"></div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 border-t-4 border-r-4 border-amber-500 rounded-tr-lg"></div>
                        <div class="absolute -bottom-2 -left-2 w-6 h-6 border-b-4 border-l-4 border-amber-500 rounded-bl-lg"></div>
                        <div class="absolute -bottom-2 -right-2 w-6 h-6 border-b-4 border-r-4 border-amber-500 rounded-br-lg"></div>

                        <div class="bg-white rounded-3xl p-4 shadow-lg qr-pulse relative overflow-hidden">
                            <div class="scan-line" id="qr-scan-line"></div>
                            <div id="qrcode"></div>
                        </div>
                    </div>
                </div>

                <!-- Order detail ringkas -->
                <div class="bg-white/70 rounded-3xl p-4 border border-amber-200">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs text-amber-700">No. Pesanan</span>
                        <span class="text-xs font-bold text-amber-900 font-mono">{{ $order->getFormattedOrderNumber() }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs text-amber-700">Meja</span>
                        <span class="text-xs font-bold text-amber-900">🪑 {{ $order->table_number }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-amber-200">
                        <span class="text-sm font-bold text-amber-900">Total Bayar</span>
                        <span class="text-lg font-bold text-amber-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <p class="text-center text-xs text-amber-600 mt-3">
                    💡 QR code ini unik untuk pesanan Anda. Kasir akan memindai dan mengkonfirmasi pembayaran.
                </p>
            </div>
        </div>

        @elseif($order->payment_method === 'cod' && $order->payment_status === 'paid')
        <div class="bg-green-50 border-2 border-green-300 rounded-3xl p-5 mb-6 text-center fade-in" style="opacity: 0;">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h2 class="text-lg font-bold text-green-800">✅ Pembayaran Lunas!</h2>
            <p class="text-sm text-green-700 mt-1">Pesanan Anda telah dibayar. Silahkan tunggu pesanan disiapkan.</p>
        </div>

        @else
        <div class="text-center mb-6">
            <p class="text-sm text-gray-600">
                Pesanan Anda sedang disiapkan. Silahkan tunggu di meja <strong>{{ $order->table_number }}</strong>
            </p>
            @if($order->payment_method === 'online')
            <p class="text-xs text-orange-600 mt-2">
                ⚠️ Untuk pembayaran online, silahkan tunggu konfirmasi sistem.
            </p>
            @endif
        </div>
        @endif

        <div class="flex gap-3">
            <a href="{{ route('order.create', $order->table_number) }}"
               class="flex-1 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold py-3 px-6 rounded-3xl shadow-lg transform hover:scale-105 transition-all duration-200 text-center">
                🛒 Pesan Lagi
            </a>
            <a href="{{ route('order.success', $order->order_number) }}"
               class="px-6 py-3 border-2 border-amber-300 text-amber-700 font-semibold rounded-3xl hover:bg-amber-50 transition text-center">
                🔄 Refresh
            </a>
        </div>
    </div>

    @if($order->payment_method === 'cod' && $order->payment_status !== 'paid')
    <script>
        // Generate QR Code yang mengarah ke halaman konfirmasi kasir
        const cashierScanUrl = '{{ route("cashier.scan", $order->order_number) }}';
        const qrContainer = document.getElementById('qrcode');

        if (qrContainer) {
            new QRCode(qrContainer, {
                text: cashierScanUrl,
                width: 200,
                height: 200,
                colorDark: '#1c0a00',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });
        }

        // Auto-refresh setiap 10 detik untuk cek status pembayaran
        let refreshInterval = setInterval(function() {
            fetch('{{ route("order.check-payment", $order->order_number) }}')
                .then(r => r.json())
                .then(data => {
                    if (data.paid) {
                        clearInterval(refreshInterval);
                        window.location.reload();
                    }
                })
                .catch(() => {});
        }, 10000);
    </script>
    @endif
</body>
</html>
