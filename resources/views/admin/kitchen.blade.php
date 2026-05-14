@extends('admin.layouts.app')

@section('title', 'Dapur')

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
    /* Status Pills */
    .status-pill {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.2rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 500;
        border: 1px solid transparent;
    }
    .status-pending { background: rgba(251,191,36,0.1); color: #fbbf24; border-color: rgba(251,191,36,0.2); }
    .status-preparing { background: rgba(96,165,250,0.1); color: #60a5fa; border-color: rgba(96,165,250,0.2); }
    .status-ready { background: rgba(74,222,128,0.1); color: #4ade80; border-color: rgba(74,222,128,0.2); }
    .status-completed { background: rgba(244,237,227,0.1); color: #f4ede3; border-color: rgba(244,237,227,0.2); }
    .status-cancelled { background: rgba(248,113,113,0.1); color: #f87171; border-color: rgba(248,113,113,0.2); }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold gradient-gold flex items-center gap-3">
                <svg class="w-8 h-8 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                </svg>
                Dapur
            </h2>
            <p class="text-[var(--gold)]/70 mt-1 text-sm tracking-wide">Kelola pesanan yang sedang aktif</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm text-[#60a5fa] bg-[#60a5fa]/10 px-4 py-2 rounded-lg border border-[#60a5fa]/20 flex items-center gap-2 font-medium">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                </svg>
                {{ $orders->count() }} Pesanan Aktif
            </span>
            <button onclick="location.reload()" class="flex items-center gap-2 bg-[rgba(184,146,74,0.1)] hover:bg-[rgba(184,146,74,0.2)] border border-[rgba(184,146,74,0.3)] text-[var(--gold)] font-semibold py-2 px-4 rounded-lg transition-all shadow-[0_4px_12px_rgba(184,146,74,0.15)] hover:shadow-[0_6px_16px_rgba(184,146,74,0.25)] text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                Refresh
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-8">
    <div class="premium-card p-5 border-l-2 border-l-[#fbbf24]">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[var(--gold)]/80 text-xs font-semibold uppercase tracking-wider">Menunggu</p>
            <div class="stat-icon-wrapper text-[#fbbf24] bg-[#fbbf24]/10 border-[#fbbf24]/20">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-white">{{ $orders->where('status', 'pending')->count() }}</p>
    </div>
    
    <div class="premium-card p-5 border-l-2 border-l-[#60a5fa]">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[var(--gold)]/80 text-xs font-semibold uppercase tracking-wider">Disiapkan</p>
            <div class="stat-icon-wrapper text-[#60a5fa] bg-[#60a5fa]/10 border-[#60a5fa]/20">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-white">{{ $orders->where('status', 'preparing')->count() }}</p>
    </div>
    
    <div class="premium-card p-5 border-l-2 border-l-[#4ade80]">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[var(--gold)]/80 text-xs font-semibold uppercase tracking-wider">Siap Saji</p>
            <div class="stat-icon-wrapper text-[#4ade80] bg-[#4ade80]/10 border-[#4ade80]/20">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-white">{{ $orders->where('status', 'ready')->count() }}</p>
    </div>
    
    <div class="premium-card p-5 border-l-2 border-l-white">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[var(--gold)]/80 text-xs font-semibold uppercase tracking-wider">Selesai Hari Ini</p>
            <div class="stat-icon-wrapper text-white bg-white/10 border-white/20">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-white">{{ $completedToday ?? 0 }}</p>
    </div>
</div>

<!-- Orders Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($orders as $order)
    <div class="premium-card flex flex-col">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-[rgba(184,146,74,0.05)] to-transparent px-5 py-4 border-b border-[rgba(184,146,74,0.15)] flex-none">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-xs text-[var(--gold)] font-mono tracking-wider">{{ $order->order_number }}</p>
                    <p class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-[var(--gold-pale)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Meja {{ $order->table_number }}
                    </p>
                </div>
                <span class="status-pill status-{{ $order->status }}">
                    @if($order->status === 'pending') 
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Menunggu
                    @elseif($order->status === 'preparing') 
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /></svg> Disiapkan
                    @elseif($order->status === 'ready') 
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg> Siap
                    @endif
                </span>
            </div>
            <div class="flex items-center gap-4 text-xs text-[var(--gold)]/60 mt-2">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    {{ $order->customer_name }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                    {{ $order->phone }}
                </span>
            </div>
        </div>

        <!-- Order Items -->
        <div class="p-5 flex-1 overflow-y-auto">
            <div class="space-y-3 mb-4">
                @foreach($order->orderItems as $item)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between text-sm gap-2">
                    <div class="flex items-start gap-2 text-white">
                        <span class="bg-[rgba(184,146,74,0.15)] text-[var(--gold)] border border-[rgba(184,146,74,0.2)] px-1.5 py-0.5 rounded text-xs font-bold whitespace-nowrap">{{ $item->quantity }}x</span>
                        <span class="leading-tight">{{ $item->product->name }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            @if($order->notes)
            <div class="mt-4 p-3 bg-[rgba(251,191,36,0.05)] border border-[rgba(251,191,36,0.15)] rounded-lg">
                <p class="text-xs text-[#fbbf24] font-semibold mb-1 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    Catatan Pelanggan:
                </p>
                <p class="text-sm text-[#fbbf24]/80 italic break-words">"{{ $order->notes }}"</p>
            </div>
            @endif
        </div>

        <!-- Order Footer & Actions -->
        <div class="flex flex-col mt-auto">
            <div class="flex items-center justify-between px-5 py-3 border-t border-[rgba(184,146,74,0.1)]">
                <div>
                    <p class="text-xs text-[var(--gold)]/60">Total Pesanan</p>
                    <p class="text-lg font-bold gradient-gold leading-none mt-1">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
                <div class="text-xs text-[var(--gold)]/50 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ $order->created_at->diffForHumans() }}
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="p-4 bg-[rgba(184,146,74,0.03)] border-t border-[rgba(184,146,74,0.1)]">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="w-full">
                    @csrf
                    @method('PUT')
                    @if($order->status === 'pending')
                    <button type="submit" name="status" value="preparing" 
                            class="w-full bg-[rgba(96,165,250,0.1)] hover:bg-[rgba(96,165,250,0.2)] text-[#60a5fa] font-semibold py-2.5 px-4 rounded-xl transition-colors border border-[rgba(96,165,250,0.2)] flex justify-center items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /></svg>
                        Mulai Siapkan
                    </button>
                    @elseif($order->status === 'preparing')
                    <button type="submit" name="status" value="ready" 
                            class="w-full bg-[rgba(74,222,128,0.1)] hover:bg-[rgba(74,222,128,0.2)] text-[#4ade80] font-semibold py-2.5 px-4 rounded-xl transition-colors border border-[rgba(74,222,128,0.2)] flex justify-center items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        Siap Saji
                    </button>
                    @elseif($order->status === 'ready')
                    <button type="submit" name="status" value="completed" 
                            class="w-full bg-gradient-to-r from-[var(--gold)] to-[var(--gold-light)] hover:from-[var(--gold-light)] hover:to-[var(--gold)] text-[var(--black)] font-semibold py-2.5 px-4 rounded-xl transition-all shadow-md flex justify-center items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Selesaikan Pesanan
                    </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-16 flex flex-col items-center justify-center bg-[rgba(184,146,74,0.02)] border border-[rgba(184,146,74,0.05)] rounded-2xl">
        <svg class="w-16 h-16 text-[var(--gold)]/20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
        </svg>
        <p class="text-[var(--gold)]/60 text-lg font-medium">Tidak ada pesanan aktif</p>
        <p class="text-[var(--gold)]/40 text-sm mt-1">Pesanan baru akan otomatis muncul di sini</p>
    </div>
    @endforelse
</div>
@endsection
