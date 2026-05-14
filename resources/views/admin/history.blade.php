@extends('admin.layouts.app')

@section('title', 'Riwayat Pesanan')

@push('styles')
<style>
    .premium-card {
        background: rgba(30,20,16,0.5);
        border: 1px solid rgba(184,146,74,0.15);
        border-radius: 1.25rem;
        transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        overflow: hidden;
        position: relative;
    }
    .premium-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.5), 0 0 0 1px rgba(184,146,74,0.3);
        background: rgba(30,20,16,0.8);
    }
    .stat-icon-wrapper {
        display: flex; align-items: center; justify-content: center;
        width: 3.5rem; height: 3.5rem;
        border-radius: 1rem;
        background: rgba(184,146,74,0.1);
        border: 1px solid rgba(184,146,74,0.2);
    }
    /* Small table styling */
    .premium-table th {
        background: rgba(184,146,74,0.05);
        color: rgba(184,146,74,0.8);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
        border-bottom: 1px solid rgba(184,146,74,0.15);
    }
    .premium-table td {
        border-bottom: 1px solid rgba(184,146,74,0.05);
    }
    .premium-table tr:hover td {
        background: rgba(184,146,74,0.03);
    }
    /* Status Pills */
    .status-pill {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.2rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 500;
        border: 1px solid transparent;
    }
    .status-completed { background: rgba(74,222,128,0.1); color: #4ade80; border-color: rgba(74,222,128,0.2); }
    .status-cancelled { background: rgba(248,113,113,0.1); color: #f87171; border-color: rgba(248,113,113,0.2); }
</style>
@endpush

@section('content')
<div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
        <h2 class="text-3xl font-bold gradient-gold flex items-center gap-3">
            <svg class="w-8 h-8 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Riwayat Pesanan
        </h2>
        <p class="text-[var(--gold)]/70 mt-1 text-sm tracking-wide">Daftar pesanan yang telah selesai atau dibatalkan</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-8">
    <!-- Completed -->
    <div class="premium-card p-5 border-l-2 border-l-[#4ade80]">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[var(--gold)]/80 text-xs font-semibold uppercase tracking-wider">Total Selesai</p>
            <div class="stat-icon-wrapper text-[#4ade80] bg-[#4ade80]/10 border-[#4ade80]/20">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-white">{{ \App\Models\Order::where('status', 'completed')->count() }}</p>
    </div>

    <!-- Cancelled -->
    <div class="premium-card p-5 border-l-2 border-l-[#f87171]">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[var(--gold)]/80 text-xs font-semibold uppercase tracking-wider">Total Dibatalkan</p>
            <div class="stat-icon-wrapper text-[#f87171] bg-[#f87171]/10 border-[#f87171]/20">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-white">{{ \App\Models\Order::where('status', 'cancelled')->count() }}</p>
    </div>

    <!-- Revenue -->
    <div class="premium-card p-5 border-l-2 border-l-[var(--gold)]">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[var(--gold)]/80 text-xs font-semibold uppercase tracking-wider">Total Pendapatan</p>
            <div class="stat-icon-wrapper text-[var(--gold)] bg-[var(--gold)]/10 border-[var(--gold)]/20">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
        </div>
        <p class="text-2xl sm:text-3xl font-bold gradient-gold">Rp {{ number_format(\App\Models\Order::where('status', 'completed')->sum('total_amount'), 0, ',', '.') }}</p>
    </div>
</div>

<!-- Orders Table -->
<div class="premium-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left premium-table">
            <thead>
                <tr>
                    <th class="px-5 py-4">Order #</th>
                    <th class="px-5 py-4">Meja</th>
                    <th class="px-5 py-4">Customer</th>
                    <th class="px-5 py-4">Items</th>
                    <th class="px-5 py-4">Total</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="transition-colors">
                    <td class="px-5 py-4 text-[var(--gold-pale)] font-mono text-sm border-b border-[rgba(184,146,74,0.05)]">{{ $order->order_number }}</td>
                    <td class="px-5 py-4 text-white text-sm border-b border-[rgba(184,146,74,0.05)]">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-[var(--gold)]/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            {{ $order->table_number }}
                        </div>
                    </td>
                    <td class="px-5 py-4 border-b border-[rgba(184,146,74,0.05)]">
                        <div class="text-sm">
                            <p class="font-medium text-white">{{ $order->customer_name }}</p>
                            <p class="text-xs text-[var(--gold)]/60 flex items-center gap-1 mt-0.5">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                {{ $order->phone }}
                            </p>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-white text-sm border-b border-[rgba(184,146,74,0.05)]">
                        <span class="bg-[rgba(184,146,74,0.1)] px-2 py-1 rounded text-xs border border-[rgba(184,146,74,0.2)] text-[var(--gold)]">{{ $order->orderItems->sum('quantity') }} items</span>
                    </td>
                    <td class="px-5 py-4 border-b border-[rgba(184,146,74,0.05)]">
                        <span class="font-bold gradient-gold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-5 py-4 border-b border-[rgba(184,146,74,0.05)]">
                        @if($order->status === 'completed')
                            <span class="status-pill status-completed">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                Completed
                            </span>
                        @elseif($order->status === 'cancelled')
                            <span class="status-pill status-cancelled">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                Cancelled
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-white text-sm border-b border-[rgba(184,146,74,0.05)]">
                        <div class="flex flex-col gap-0.5">
                            <span>{{ $order->created_at->format('d M Y') }}</span>
                            <span class="text-xs text-[var(--gold)]/50">{{ $order->created_at->format('H:i') }}</span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center text-[var(--gold)]/50 text-sm border-b border-[rgba(184,146,74,0.05)]">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <svg class="w-8 h-8 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Belum ada riwayat pesanan
                        </div>
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
@endsection
