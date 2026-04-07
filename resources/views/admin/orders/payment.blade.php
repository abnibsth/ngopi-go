@extends('admin.layouts.app')

@section('title', 'Update Pembayaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold gradient-gold">💳 Update Pembayaran</h2>
                <p class="text-[#C69C6D] mt-1">{{ $order->order_number }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" 
               class="bg-[#C69C6D]/20 hover:bg-[#C69C6D]/40 border border-[#C69C6D]/50 text-[#F5F0E6] font-semibold py-2 px-4 rounded-lg transition backdrop-blur-sm">
                ← Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-900/50 border border-green-500/50 text-green-200 px-6 py-4 rounded-xl mb-6">
        ✅ {{ session('success') }}
    </div>
    @endif

    <!-- Order Info Card -->
    <div class="bg-[#1a120f] rounded-xl shadow-xl overflow-hidden border border-[#C69C6D]/20 mb-6">
        <div class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] px-6 py-4 border-b border-[#C69C6D]/20">
            <h3 class="text-lg font-bold text-[#F5F0E6]">📋 Detail Pesanan</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-[#C69C6D] uppercase tracking-wider mb-1">No. Order</p>
                    <p class="text-lg font-bold text-[#F5F0E6]">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-xs text-[#C69C6D] uppercase tracking-wider mb-1">Meja</p>
                    <p class="text-lg font-bold text-[#F5F0E6]">🪑 {{ $order->table_number }}</p>
                </div>
                <div>
                    <p class="text-xs text-[#C69C6D] uppercase tracking-wider mb-1">Customer</p>
                    <p class="text-[#F5F0E6]">{{ $order->customer_name }}</p>
                    <p class="text-xs text-[#C69C6D]">📱 {{ $order->phone }}</p>
                </div>
                <div>
                    <p class="text-xs text-[#C69C6D] uppercase tracking-wider mb-1">Total</p>
                    <p class="text-xl font-bold gradient-gold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Status Card -->
    <div class="bg-[#1a120f] rounded-xl shadow-xl overflow-hidden border border-[#C69C6D]/20">
        <div class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] px-6 py-4 border-b border-[#C69C6D]/20">
            <h3 class="text-lg font-bold text-[#F5F0E6]">💳 Status Pembayaran</h3>
        </div>
        <div class="p-6">
            <!-- Current Status -->
            <div class="mb-6">
                <p class="text-sm text-[#C69C6D] mb-2">Status Saat Ini:</p>
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium
                    {{ $order->getPaymentStatusBadgeClass() }}">
                    {!! $order->getPaymentStatusLabel() !!}
                </span>
            </div>

            <!-- Payment Method -->
            <div class="mb-6">
                <p class="text-sm text-[#C69C6D] mb-2">Metode Pembayaran:</p>
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium
                    @if($order->payment_method === 'cod') bg-green-900/50 text-green-400 border border-green-500/30
                    @else bg-blue-900/50 text-blue-400 border border-blue-500/30
                    @endif">
                    @if($order->payment_method === 'cod')
                        💵 COD (Bayar di Tempat)
                    @else
                        💳 Online Payment
                    @endif
                </span>
            </div>

            <!-- Update Form -->
            <form action="{{ route('admin.orders.payment', $order->id) }}" method="POST" class="mt-6">
                @csrf
                <div class="space-y-4">
                    <p class="text-sm text-[#C69C6D]">Update Status:</p>
                    
                    <label class="flex items-center gap-3 p-4 rounded-lg border border-[#C69C6D]/20 cursor-pointer hover:bg-[#C69C6D]/10 transition">
                        <input type="radio" 
                               name="payment_status" 
                               value="pending"
                               {{ $order->payment_status === 'pending' ? 'checked' : '' }}
                               class="w-4 h-4 text-[#C69C6D]">
                        <span class="text-[#F5F0E6]">⏳ Belum Lunas</span>
                    </label>
                    
                    <label class="flex items-center gap-3 p-4 rounded-lg border border-[#C69C6D]/20 cursor-pointer hover:bg-[#C69C6D]/10 transition">
                        <input type="radio" 
                               name="payment_status" 
                               value="paid"
                               {{ $order->payment_status === 'paid' ? 'checked' : '' }}
                               class="w-4 h-4 text-[#C69C6D]">
                        <span class="text-[#F5F0E6]">✅ Lunas</span>
                    </label>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] hover:from-[#D4AF7A] hover:to-[#C69C6D] text-[#121212] font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-[#C69C6D]/50 transform hover:scale-[1.02] transition-all duration-200">
                        💾 Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.orders.receipt', $order->id) }}" 
           class="flex-1 text-center bg-green-600/20 hover:bg-green-600/40 border border-green-600/50 text-green-400 font-semibold py-3 px-6 rounded-xl transition">
            🧾 Cetak Receipt
        </a>
        <a href="{{ route('admin.orders.edit', $order->id) }}" 
           class="flex-1 text-center bg-blue-600/20 hover:bg-blue-600/40 border border-blue-600/50 text-blue-400 font-semibold py-3 px-6 rounded-xl transition">
            ✏️ Edit Pesanan
        </a>
    </div>
</div>
@endsection
