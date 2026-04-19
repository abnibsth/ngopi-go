<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $order->getFormattedOrderNumber() }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #receipt-area, #receipt-area * {
                visibility: visible;
            }
            #receipt-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
        
        .receipt-container {
            max-width: 380px;
            margin: 0 auto;
            background: white;
            color: black;
            padding: 15px;
            font-family: 'Courier New', monospace;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .text-sm { font-size: 12px; }
        .text-xs { font-size: 10px; }
        .text-lg { font-size: 16px; }
        .text-xl { font-size: 20px; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 12px; }
        .mb-4 { margin-bottom: 16px; }
        .mt-1 { margin-top: 4px; }
        .mt-2 { margin-top: 8px; }
        .py-2 { padding-top: 8px; padding-bottom: 8px; }
        .border-b { border-bottom: 1px dashed #000; }
        .border-b-2 { border-bottom: 2px solid #000; }
        .border-t { border-top: 1px dashed #000; }
        .w-full { width: 100%; }
        .flex { display: flex; }
        .justify-between { justify-content: space-between; }
        .items-center { align-items: center; }
        .gap-1 { gap: 4px; }
        .gap-2 { gap: 8px; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Print Button -->
    <div class="no-print container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('admin.orders.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                ← Kembali
            </a>
            <button onclick="window.print()" 
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition shadow-lg">
                🖨️ Cetak Receipt
            </button>
        </div>
        
        @if(session('success'))
        <div class="bg-green-100 border border-green-500 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif
    </div>

    <!-- Receipt -->
    <div id="receipt-area" class="container mx-auto px-4 py-6">
        <div class="receipt-container">
            <!-- Header -->
            <div class="text-center mb-3 pb-3 border-b-2">
                <div class="flex justify-center mb-2">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="NgopiGo Logo" style="width: 60px; height: 60px; filter: grayscale(100%); object-fit: cover; border-radius: 50%;">
                </div>
                <h1 class="text-xl font-bold">NGOPIGO</h1>
                <p class="text-xs">Coffee & Chill</p>
                <p class="text-xs mt-1">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <!-- Order Info -->
            <div class="mb-3 pb-3 border-b">
                <div class="flex justify-between mb-1">
                    <span class="text-xs">No. Antrian</span>
                    <span class="text-xs font-bold">#{{ $order->getFormattedQueueNumber() }}</span>
                </div>
                <div class="flex justify-between mb-1">
                    <span class="text-xs">No. Pesanan</span>
                    <span class="text-xs font-bold">{{ $order->getFormattedOrderNumber() }}</span>
                </div>
                <div class="flex justify-between mb-1">
                    <span class="text-xs">Meja</span>
                    <span class="text-xs">🪑 {{ $order->table_number }}</span>
                </div>
                <div class="flex justify-between mb-1">
                    <span class="text-xs">Pelanggan</span>
                    <span class="text-xs">{{ $order->customer_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-xs">Status</span>
                    <span class="text-xs font-bold">
                        @php
                            $statusLabels = [
                                'pending' => 'Menunggu',
                                'preparing' => 'Disiapkan',
                                'ready' => 'Siap',
                                'completed' => 'Selesai',
                                'cancelled' => 'Batal'
                            ];
                        @endphp
                        {{ $statusLabels[$order->status] ?? $order->status }}
                    </span>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-3 pb-3 border-b">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Item</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td class="py-2">
                                <div class="font-bold">{{ $order->getProductCode($item) }}</div>
                                <div>{{ $item->product->name }}</div>
                            </td>
                            <td class="text-center">{{ $item->quantity }}x</td>
                            <td class="text-right font-bold">
                                {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @if(!$loop->last)
                        <tr><td colspan="3" class="py-1"></td></tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                
                @if($order->notes)
                <div class="mt-2 pt-2 border-t text-xs">
                    <span class="font-bold">Catatan:</span> {{ $order->notes }}
                </div>
                @endif
            </div>

            <!-- Payment Summary -->
            <div class="mb-3">
                <div class="flex justify-between mb-1">
                    <span class="text-xs">Pembayaran</span>
                    <span class="text-xs font-bold">
                        @if($order->payment_method === 'cod')
                            COD (Tunai)
                        @else
                            Online
                        @endif
                    </span>
                </div>
                <div class="flex justify-between mb-1">
                    <span class="text-xs">Status Bayar</span>
                    <span class="text-xs font-bold">
                        {{ $order->payment_status === 'paid' ? 'LUNAS' : 'BELUM LUNAS' }}
                    </span>
                </div>
                <div class="flex justify-between text-lg border-t pt-2 mt-2">
                    <span class="font-bold">TOTAL</span>
                    <span class="font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center pt-3 border-t mt-3">
                <p class="text-xs">Terima kasih telah berkunjung!</p>
                <p class="text-xs mt-1">NgopiGo - Premium Coffee Experience</p>
                <p class="text-xs mt-2" style="font-size: 9px;">Order dibuat: {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
            </div>
        </div>
    </div>

    <script>
        // Auto print on load (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
