@extends('admin.layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold gradient-gold">📜 Riwayat Pesanan</h2>
            <p class="text-[#C69C6D] mt-1">Daftar pesanan yang telah selesai atau dibatalkan</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Completed -->
        <div class="bg-gradient-to-br from-[#1a2f1a] to-[#0f1f0f] rounded-2xl shadow-xl p-6 text-white border border-[#4ade80]/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#C69C6D] text-sm mb-1">Total Selesai</p>
                    <p class="text-3xl font-bold text-[#4ade80]">{{ \App\Models\Order::where('status', 'completed')->count() }}</p>
                </div>
                <div class="text-5xl opacity-50">✅</div>
            </div>
        </div>

        <!-- Cancelled -->
        <div class="bg-gradient-to-br from-[#2f1a1a] to-[#1f0f0f] rounded-2xl shadow-xl p-6 text-white border border-[#f87171]/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#C69C6D] text-sm mb-1">Total Dibatalkan</p>
                    <p class="text-3xl font-bold text-[#f87171]">{{ \App\Models\Order::where('status', 'cancelled')->count() }}</p>
                </div>
                <div class="text-5xl opacity-50">❌</div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="bg-gradient-to-br from-[#2f261a] to-[#1f190f] rounded-2xl shadow-xl p-6 text-white border border-[#fbbf24]/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#C69C6D] text-sm mb-1">Total Pendapatan</p>
                    <p class="text-3xl font-bold gradient-gold">Rp {{ number_format(\App\Models\Order::where('status', 'completed')->sum('total_amount'), 0, ',', '.') }}</p>
                </div>
                <div class="text-5xl opacity-50">💰</div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-[#2E1F1A]/50 rounded-2xl shadow-xl border border-[#C69C6D]/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#C69C6D]/20">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-[#C69C6D]">Order Number</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-[#C69C6D]">Meja</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-[#C69C6D]">Customer</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-[#C69C6D]">Items</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-[#C69C6D]">Total</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-[#C69C6D]">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-[#C69C6D]">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#C69C6D]/10">
                    @forelse($orders as $order)
                    <tr class="hover:bg-[#C69C6D]/5 transition">
                        <td class="px-6 py-4 text-white font-mono text-sm">{{ $order->order_number }}</td>
                        <td class="px-6 py-4 text-white">{{ $order->table_number }}</td>
                        <td class="px-6 py-4 text-white">
                            <div>
                                <p class="font-medium">{{ $order->customer_name }}</p>
                                <p class="text-xs text-[#C69C6D]">{{ $order->phone }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-white text-sm">{{ $order->orderItems->sum('quantity') }} item(s)</td>
                        <td class="px-6 py-4 text-[#C69C6D] font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @if($order->status === 'completed')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-900/50 text-green-400 border border-green-500/30">
                                    ✅ Completed
                                </span>
                            @elseif($order->status === 'cancelled')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-red-900/50 text-red-400 border border-red-500/30">
                                    ❌ Cancelled
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-white text-sm">{{ $order->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-[#C69C6D]">
                            <div class="text-6xl mb-4">📜</div>
                            <p class="text-lg font-medium">Belum ada riwayat pesanan</p>
                            <p class="text-sm mt-2">Riwayat pesanan yang selesai atau dibatalkan akan muncul di sini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
