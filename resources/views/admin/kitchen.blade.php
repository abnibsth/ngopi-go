@extends('admin.layouts.app')

@section('title', 'Dapur')

@push('styles')
<style>
    .premium-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .premium-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(198, 156, 109, 0.2);
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold gradient-gold">🍳 Dapur</h2>
            <p class="text-[#C69C6D] mt-1">Kelola pesanan yang sedang aktif</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm text-[#C69C6D] bg-[#C69C6D]/20 px-4 py-2 rounded-lg border border-[#C69C6D]/30">
                🔥 {{ $orders->count() }} Pesanan Aktif
            </span>
            <button onclick="location.reload()" class="bg-[#C69C6D] hover:bg-[#D4AF7A] text-[#121212] font-semibold py-2 px-4 rounded-lg transition shadow-lg">
                🔄 Refresh
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-gradient-to-br from-[#2f261a] to-[#1f190f] rounded-2xl shadow-xl p-6 text-white border border-[#fbbf24]/30">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#C69C6D] text-sm mb-1">Menunggu</p>
                <p class="text-3xl font-bold text-[#fbbf24]">{{ $orders->where('status', 'pending')->count() }}</p>
            </div>
            <div class="text-5xl opacity-50">⏳</div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-[#1a2330] to-[#0f151f] rounded-2xl shadow-xl p-6 text-white border border-[#60a5fa]/30">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#C69C6D] text-sm mb-1">Disiapkan</p>
                <p class="text-3xl font-bold text-[#60a5fa]">{{ $orders->where('status', 'preparing')->count() }}</p>
            </div>
            <div class="text-5xl opacity-50">🔥</div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-[#1a2f1a] to-[#0f1f0f] rounded-2xl shadow-xl p-6 text-white border border-[#4ade80]/30">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#C69C6D] text-sm mb-1">Siap</p>
                <p class="text-3xl font-bold text-[#4ade80]">{{ $orders->where('status', 'ready')->count() }}</p>
            </div>
            <div class="text-5xl opacity-50">✅</div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-[#2a1a2f] to-[#1a0f1f] rounded-2xl shadow-xl p-6 text-white border border-[#c084fc]/30">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#C69C6D] text-sm mb-1">Selesai</p>
                <p class="text-3xl font-bold text-[#F5F0E6]">{{ $completedToday ?? 0 }}</p>
            </div>
            <div class="text-5xl opacity-50">✓</div>
        </div>
    </div>
</div>

<!-- Orders Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($orders as $order)
    <div class="bg-[#2E1F1A]/50 rounded-2xl shadow-xl overflow-hidden border border-[#C69C6D]/20 premium-card">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] px-6 py-4 border-b border-[#C69C6D]/20">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-xs text-[#C69C6D] font-mono">{{ $order->order_number }}</p>
                    <p class="text-lg font-bold text-white">🪑 Meja {{ $order->table_number }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium border
                    @if($order->status === 'pending') bg-yellow-900/50 text-yellow-400 border-yellow-500/30
                    @elseif($order->status === 'preparing') bg-blue-900/50 text-blue-400 border-blue-500/30
                    @elseif($order->status === 'ready') bg-green-900/50 text-green-400 border-green-500/30
                    @else bg-gray-900/50 text-gray-400 border-gray-500/30
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
            <div class="flex items-center gap-4 text-sm text-[#C69C6D] mt-2">
                <span>👤 {{ $order->customer_name }}</span>
                <span>📱 {{ $order->phone }}</span>
            </div>
        </div>

        <!-- Order Items -->
        <div class="p-6">
            <div class="space-y-3 mb-4">
                @foreach($order->orderItems as $item)
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2 text-white">
                        <span class="bg-[#C69C6D]/20 text-[#C69C6D] px-2 py-1 rounded text-xs font-bold">{{ $item->quantity }}x</span>
                        <span>{{ $item->product->name }}</span>
                    </div>
                </div>
                @endforeach

                @if($order->notes)
                <div class="mt-4 p-3 bg-yellow-900/30 border border-yellow-700/50 rounded-lg">
                    <p class="text-xs text-yellow-500 font-semibold mb-1">📝 Catatan Pelanggan:</p>
                    <p class="text-sm text-yellow-100 italic break-words">"{{ $order->notes }}"</p>
                </div>
                @endif
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-[#C69C6D]/20">
                <div>
                    <p class="text-xs text-[#C69C6D]">Total</p>
                    <p class="text-xl font-bold gradient-gold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
                <div class="text-xs text-[#C69C6D]">
                    {{ $order->created_at->diffForHumans() }}
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="p-4 bg-[#1a120f]/50 border-t border-[#C69C6D]/20">
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-2">
                @csrf
                @method('PUT')
                @if($order->status === 'pending')
                <button type="submit" name="status" value="preparing" 
                        class="w-full bg-blue-900/50 hover:bg-blue-800/70 text-blue-400 font-semibold py-2 px-4 rounded-lg transition border border-blue-500/30">
                    🔥 Mulai Siapkan
                </button>
                @elseif($order->status === 'preparing')
                <button type="submit" name="status" value="ready" 
                        class="w-full bg-green-900/50 hover:bg-green-800/70 text-green-400 font-semibold py-2 px-4 rounded-lg transition border border-green-500/30">
                    ✅ Siap Saji
                </button>
                @elseif($order->status === 'ready')
                <button type="submit" name="status" value="completed" 
                        class="w-full bg-[#C69C6D] hover:bg-[#D4AF7A] text-[#121212] font-semibold py-2 px-4 rounded-lg transition shadow-lg">
                    ✓ Selesaikan Pesanan
                </button>
                @endif
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
        <div class="text-6xl mb-4">🍳</div>
        <p class="text-[#C69C6D] text-lg font-medium">Tidak ada pesanan aktif</p>
        <p class="text-[#C69C6D] text-sm mt-2">Pesanan baru akan muncul di sini</p>
    </div>
    @endforelse
</div>
@endsection  
