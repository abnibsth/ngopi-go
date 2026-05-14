@extends('admin.layouts.app')

@section('title', 'Dashboard')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    .premium-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(184,146,74,0.3), transparent);
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    .premium-card:hover::before { opacity: 1; }

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
    .status-pending { background: rgba(251,191,36,0.1); color: #fbbf24; border-color: rgba(251,191,36,0.2); }
    .status-preparing { background: rgba(96,165,250,0.1); color: #60a5fa; border-color: rgba(96,165,250,0.2); }
    .status-ready { background: rgba(74,222,128,0.1); color: #4ade80; border-color: rgba(74,222,128,0.2); }
    .status-completed { background: rgba(244,237,227,0.1); color: #f4ede3; border-color: rgba(244,237,227,0.2); }
    .status-cancelled { background: rgba(248,113,113,0.1); color: #f87171; border-color: rgba(248,113,113,0.2); }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
        <h2 class="text-3xl font-bold gradient-gold flex items-center gap-3">
            <svg class="w-8 h-8 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
            </svg>
            Dashboard
        </h2>
        <p class="text-[var(--gold)]/70 mt-1 text-sm tracking-wide">Ringkasan performa dan penjualan restoran</p>
    </div>
    
    <div class="flex items-center gap-3 flex-wrap">
        <form method="GET" class="flex items-center gap-2">
            <label for="months" class="text-xs text-[var(--gold)]/80 uppercase tracking-wider">Filter:</label>
            <div class="relative">
                <select id="months" name="months"
                        onchange="this.form.submit()"
                        class="appearance-none bg-[rgba(184,146,74,0.05)] text-[var(--cream)] border border-[rgba(184,146,74,0.3)] rounded-lg pl-3 pr-8 py-1.5 text-sm focus:outline-none focus:border-[var(--gold)] transition-colors cursor-pointer">
                    <option value="1"  class="bg-[var(--dark-brown)]" {{ (int)($periodMonths ?? 1) === 1 ? 'selected' : '' }}>Bulan ini</option>
                    <option value="3"  class="bg-[var(--dark-brown)]" {{ (int)($periodMonths ?? 1) === 3 ? 'selected' : '' }}>3 bln terakhir</option>
                    <option value="6"  class="bg-[var(--dark-brown)]" {{ (int)($periodMonths ?? 1) === 6 ? 'selected' : '' }}>6 bln terakhir</option>
                    <option value="12" class="bg-[var(--dark-brown)]" {{ (int)($periodMonths ?? 1) === 12 ? 'selected' : '' }}>1 thn terakhir</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-[var(--gold)]">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>
        </form>
        <span class="text-sm text-[var(--gold)] bg-[rgba(184,146,74,0.1)] px-3 py-1.5 rounded-lg border border-[rgba(184,146,74,0.2)] flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            {{ now()->format('d M Y') }}
        </span>
    </div>
</div>

<!-- Quick Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
    <!-- Total Pendapatan -->
    <div class="premium-card p-5 border-l-2 border-l-[#4ade80]">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[var(--gold)]/80 text-xs font-semibold uppercase tracking-wider">Total Pendapatan</p>
            <div class="stat-icon-wrapper text-[#4ade80] bg-[#4ade80]/10 border-[#4ade80]/20">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-white mb-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        <div class="flex items-center gap-1.5 text-[#4ade80] text-xs">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            <span>{{ $totalOrders }} pesanan selesai</span>
        </div>
    </div>

    <!-- Pesanan Aktif -->
    <div class="premium-card p-5 border-l-2 border-l-[#60a5fa]">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[var(--gold)]/80 text-xs font-semibold uppercase tracking-wider">Pesanan Aktif</p>
            <div class="stat-icon-wrapper text-[#60a5fa] bg-[#60a5fa]/10 border-[#60a5fa]/20">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                </svg>
            </div>
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-white mb-2">{{ $pendingOrders }}</p>
        <div class="flex items-center gap-1.5 text-[#60a5fa] text-xs">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Perlu diproses segera</span>
        </div>
    </div>

    <!-- Produk -->
    <div class="premium-card p-5 border-l-2 border-l-[#fbbf24]">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[var(--gold)]/80 text-xs font-semibold uppercase tracking-wider">Total Produk</p>
            <div class="stat-icon-wrapper text-[#fbbf24] bg-[#fbbf24]/10 border-[#fbbf24]/20">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </div>
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-white mb-2">{{ $activeProducts }}<span class="text-base text-white/50">/{{ $totalProducts }}</span></p>
        <div class="flex items-center gap-1.5 text-[#fbbf24] text-xs">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
            </svg>
            <span>Item tersedia</span>
        </div>
    </div>

    <!-- Admin -->
    <div class="premium-card p-5 border-l-2 border-l-[#c084fc]">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[var(--gold)]/80 text-xs font-semibold uppercase tracking-wider">Tim Aktif</p>
            <div class="stat-icon-wrapper text-[#c084fc] bg-[#c084fc]/10 border-[#c084fc]/20">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
        </div>
        <p class="text-2xl sm:text-3xl font-bold text-white mb-2">{{ $adminCount }}</p>
        <div class="flex items-center gap-1.5 text-[#c084fc] text-xs">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Akses terverifikasi</span>
        </div>
    </div>
</div>

<!-- Period Breakdown (Mini Cards) -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="premium-card p-4 flex items-center justify-between">
        <div>
            <p class="text-xs text-[var(--gold)]/70 uppercase tracking-wider mb-1">Hari Ini</p>
            <p class="text-lg font-bold text-white">{{ $todayOrdersCount }} pesanan</p>
            <p class="text-sm text-[#4ade80] font-medium">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="w-10 h-10 rounded-full bg-[rgba(184,146,74,0.1)] text-[var(--gold)] flex items-center justify-center border border-[rgba(184,146,74,0.2)]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" /></svg>
        </div>
    </div>
    <div class="premium-card p-4 flex items-center justify-between">
        <div>
            <p class="text-xs text-[var(--gold)]/70 uppercase tracking-wider mb-1">Minggu Ini</p>
            <p class="text-lg font-bold text-white">{{ $weekOrders }} pesanan</p>
            <p class="text-sm text-[#60a5fa] font-medium">Rp {{ number_format($weekRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="w-10 h-10 rounded-full bg-[rgba(184,146,74,0.1)] text-[var(--gold)] flex items-center justify-center border border-[rgba(184,146,74,0.2)]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
        </div>
    </div>
    <div class="premium-card p-4 flex items-center justify-between">
        <div>
            <p class="text-xs text-[var(--gold)]/70 uppercase tracking-wider mb-1">{{ (int)($periodMonths ?? 1) === 1 ? 'Bulan Ini' : ((int)($periodMonths ?? 1) . ' Bulan Terakhir') }}</p>
            <p class="text-lg font-bold text-white">{{ $monthOrders }} pesanan</p>
            <p class="text-sm text-[#c084fc] font-medium">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="w-10 h-10 rounded-full bg-[rgba(184,146,74,0.1)] text-[var(--gold)] flex items-center justify-center border border-[rgba(184,146,74,0.2)]">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg>
        </div>
    </div>
</div>

<!-- Charts Row 1 -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Sales Chart -->
    <div class="premium-card p-5 lg:col-span-2">
        <h3 class="text-lg font-serif font-semibold text-[var(--gold-pale)] mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-[var(--gold)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" /></svg>
            Grafik Penjualan 7 Hari Terakhir
        </h3>
        <div class="relative h-64 w-full">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Top Products -->
    <div class="premium-card p-5">
        <h3 class="text-lg font-serif font-semibold text-[var(--gold-pale)] mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-[var(--gold)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" /></svg>
            Top 5 Produk Terlaris
        </h3>
        <div class="space-y-3">
            @forelse($topProducts as $index => $product)
            <div class="flex items-center gap-3 p-2.5 rounded-xl border border-transparent hover:border-[rgba(184,146,74,0.15)] hover:bg-[rgba(184,146,74,0.05)] transition-colors">
                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-[var(--gold)] to-[var(--gold-light)] flex items-center justify-center text-[var(--black)] font-bold text-xs shadow-md">
                    {{ $index + 1 }}
                </div>
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-lg border border-[rgba(184,146,74,0.2)]">
                @else
                <div class="w-10 h-10 rounded-lg bg-[var(--dark-brown)] border border-[rgba(184,146,74,0.2)] flex items-center justify-center">
                    <svg class="w-5 h-5 text-[var(--gold)]/50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-white text-sm truncate">{{ $product->name }}</p>
                    <p class="text-xs text-[var(--gold)]/80">{{ $product->total_sold }} terjual</p>
                </div>
            </div>
            @empty
            <p class="text-[var(--gold)]/60 text-center py-6 text-sm">Belum ada data penjualan</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Charts Row 2 -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Category Chart -->
    <div class="premium-card p-5">
        <h3 class="text-lg font-serif font-semibold text-[var(--gold-pale)] mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-[var(--gold)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg>
            Penjualan per Kategori
        </h3>
        <div class="relative h-56 w-full flex justify-center">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <!-- Top 10 Chart -->
    <div class="premium-card p-5 lg:col-span-2">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-3">
            <h3 class="text-lg font-serif font-semibold text-[var(--gold-pale)] flex items-center gap-2">
                <svg class="w-5 h-5 text-[var(--gold)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                Top 10 Produk Terlaris
            </h3>
            <div class="flex gap-1.5 bg-[rgba(0,0,0,0.2)] p-1 rounded-lg border border-[rgba(184,146,74,0.15)]">
                <button type="button" onclick="switchPeriod('7days')" id="btn-7days"
                        class="px-3 py-1 rounded text-xs font-medium transition-colors bg-[var(--gold)] text-[var(--black)] shadow-sm">
                    7 Hari
                </button>
                <button type="button" onclick="switchPeriod('month')" id="btn-month"
                        class="px-3 py-1 rounded text-xs font-medium transition-colors text-[var(--gold)] hover:bg-[rgba(184,146,74,0.1)]">
                    {{ (int)($periodMonths ?? 1) === 1 ? 'Bulan Ini' : ((int)($periodMonths ?? 1) . ' Bulan') }}
                </button>
            </div>
        </div>
        <div class="relative h-64 w-full">
            <canvas id="topProductsChart"></canvas>
        </div>
        <p class="text-xs text-[var(--gold)]/60 text-center mt-2" id="chartPeriodLabel">Periode: 7 Hari Terakhir</p>
    </div>
</div>

<!-- Status & Payment Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Orders by Status -->
    <div class="premium-card p-5">
        <h3 class="text-lg font-serif font-semibold text-[var(--gold-pale)] mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-[var(--gold)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75M6.75 21h9" /></svg>
            Status Pesanan Saat Ini
        </h3>
        <div class="grid grid-cols-2 gap-3 sm:gap-4">
            <div class="rounded-xl p-4 bg-[rgba(251,191,36,0.05)] border border-[rgba(251,191,36,0.15)]">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-5 h-5 text-[#fbbf24] opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="text-2xl font-bold text-[#fbbf24]">{{ $ordersByStatus['pending'] ?? 0 }}</span>
                </div>
                <p class="text-xs font-medium text-[var(--gold)]/70 uppercase tracking-wider">Menunggu</p>
            </div>
            <div class="rounded-xl p-4 bg-[rgba(96,165,250,0.05)] border border-[rgba(96,165,250,0.15)]">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-5 h-5 text-[#60a5fa] opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /></svg>
                    <span class="text-2xl font-bold text-[#60a5fa]">{{ $ordersByStatus['preparing'] ?? 0 }}</span>
                </div>
                <p class="text-xs font-medium text-[var(--gold)]/70 uppercase tracking-wider">Disiapkan</p>
            </div>
            <div class="rounded-xl p-4 bg-[rgba(74,222,128,0.05)] border border-[rgba(74,222,128,0.15)]">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-5 h-5 text-[#4ade80] opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="text-2xl font-bold text-[#4ade80]">{{ $ordersByStatus['ready'] ?? 0 }}</span>
                </div>
                <p class="text-xs font-medium text-[var(--gold)]/70 uppercase tracking-wider">Siap Saji</p>
            </div>
            <div class="rounded-xl p-4 bg-[rgba(244,237,227,0.05)] border border-[rgba(244,237,227,0.15)]">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-5 h-5 text-white opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    <span class="text-2xl font-bold text-white">{{ $ordersByStatus['completed'] ?? 0 }}</span>
                </div>
                <p class="text-xs font-medium text-[var(--gold)]/70 uppercase tracking-wider">Selesai</p>
            </div>
        </div>
    </div>

    <!-- Payment Methods -->
    <div class="premium-card p-5">
        <h3 class="text-lg font-serif font-semibold text-[var(--gold-pale)] mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-[var(--gold)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" /></svg>
            Metode Pembayaran (Periode Aktif)
        </h3>
        <div class="flex flex-col gap-3">
            <div class="flex items-center justify-between p-4 rounded-xl bg-[rgba(184,146,74,0.05)] border border-[rgba(184,146,74,0.1)]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#4ade80]/10 text-[#4ade80] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">COD / Kasir</p>
                        <p class="text-xs text-[var(--gold)]/60">Bayar di tempat</p>
                    </div>
                </div>
                <span class="text-xl font-bold text-[#4ade80]">{{ $paymentsByMethod['cod'] ?? 0 }}</span>
            </div>
            
            <div class="flex items-center justify-between p-4 rounded-xl bg-[rgba(184,146,74,0.05)] border border-[rgba(184,146,74,0.1)]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#60a5fa]/10 text-[#60a5fa] flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">Midtrans Online</p>
                        <p class="text-xs text-[var(--gold)]/60">Transfer/E-Wallet</p>
                    </div>
                </div>
                <span class="text-xl font-bold text-[#60a5fa]">{{ $paymentsByMethod['online'] ?? 0 }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="premium-card mb-8">
    <div class="p-5 border-b border-[rgba(184,146,74,0.15)] flex items-center justify-between">
        <h3 class="text-lg font-serif font-semibold text-[var(--gold-pale)] flex items-center gap-2">
            <svg class="w-5 h-5 text-[var(--gold)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Pesanan Terbaru
        </h3>
        <a href="{{ route('admin.orders.index') }}" class="text-[var(--gold)] hover:text-white text-sm font-medium transition-colors flex items-center gap-1">
            Lihat Semua
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left premium-table">
            <thead>
                <tr>
                    <th class="px-5 py-3">Order #</th>
                    <th class="px-5 py-3">Customer</th>
                    <th class="px-5 py-3">Meja</th>
                    <th class="px-5 py-3">Total</th>
                    <th class="px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr class="transition-colors">
                    <td class="px-5 py-3 border-b border-[rgba(184,146,74,0.05)]">
                        <span class="font-mono text-[var(--gold-pale)] text-sm">{{ $order->order_number }}</span>
                        <div class="text-[0.65rem] text-[var(--gold)]/50 mt-0.5">{{ $order->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-5 py-3 border-b border-[rgba(184,146,74,0.05)]">
                        <p class="text-sm font-medium text-white">{{ $order->customer_name }}</p>
                        <p class="text-xs text-[var(--gold)]/60 flex items-center gap-1 mt-0.5">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            {{ $order->phone }}
                        </p>
                    </td>
                    <td class="px-5 py-3 border-b border-[rgba(184,146,74,0.05)]">
                        <div class="flex items-center gap-1.5 text-sm text-[var(--cream)]">
                            <svg class="w-4 h-4 text-[var(--gold)]/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            {{ $order->table_number }}
                        </div>
                    </td>
                    <td class="px-5 py-3 border-b border-[rgba(184,146,74,0.05)]">
                        <p class="text-sm font-semibold gradient-gold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <p class="text-xs text-[var(--gold)]/60">{{ $order->orderItems->count() }} items</p>
                    </td>
                    <td class="px-5 py-3 border-b border-[rgba(184,146,74,0.05)]">
                        <span class="status-pill status-{{ $order->status }}">
                            @if($order->status === 'pending') <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Menunggu
                            @elseif($order->status === 'preparing') <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" /></svg> Diproses
                            @elseif($order->status === 'ready') <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Siap
                            @elseif($order->status === 'completed') <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Selesai
                            @else <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg> Batal
                            @endif
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-8 text-center text-[var(--gold)]/50 text-sm">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <svg class="w-8 h-8 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                            Belum ada pesanan masuk
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Quick Action Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    <a href="{{ route('admin.kitchen') }}" class="group block p-5 rounded-2xl bg-[rgba(96,165,250,0.05)] border border-[rgba(96,165,250,0.15)] hover:bg-[rgba(96,165,250,0.1)] hover:border-[rgba(96,165,250,0.3)] transition-all duration-300">
        <div class="w-12 h-12 rounded-xl bg-[#60a5fa]/10 text-[#60a5fa] flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /></svg>
        </div>
        <h4 class="text-lg font-semibold text-white mb-1">Dapur Order</h4>
        <p class="text-sm text-[var(--gold)]/60 group-hover:text-[var(--gold)]/80 transition-colors">Kelola antrean dan status hidangan</p>
    </a>

    <a href="{{ route('admin.products.index') }}" class="group block p-5 rounded-2xl bg-[rgba(251,191,36,0.05)] border border-[rgba(251,191,36,0.15)] hover:bg-[rgba(251,191,36,0.1)] hover:border-[rgba(251,191,36,0.3)] transition-all duration-300">
        <div class="w-12 h-12 rounded-xl bg-[#fbbf24]/10 text-[#fbbf24] flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
        </div>
        <h4 class="text-lg font-semibold text-white mb-1">Katalog Produk</h4>
        <p class="text-sm text-[var(--gold)]/60 group-hover:text-[var(--gold)]/80 transition-colors">Tambah atau update harga menu</p>
    </a>

    <a href="{{ route('admin.history') }}" class="group block p-5 rounded-2xl bg-[rgba(184,146,74,0.05)] border border-[rgba(184,146,74,0.15)] hover:bg-[rgba(184,146,74,0.1)] hover:border-[rgba(184,146,74,0.3)] transition-all duration-300">
        <div class="w-12 h-12 rounded-xl bg-[var(--gold)]/10 text-[var(--gold)] flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <h4 class="text-lg font-semibold text-white mb-1">Riwayat Selesai</h4>
        <p class="text-sm text-[var(--gold)]/60 group-hover:text-[var(--gold)]/80 transition-colors">Laporan dan pesanan historis</p>
    </a>
</div>

@push('scripts')
<script>
    // Sales Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($salesChart);

    // Chart global defaults for dark premium theme
    Chart.defaults.color = 'rgba(184,146,74,0.6)';
    Chart.defaults.font.family = "'Inter', sans-serif";

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesData.map(item => item.date),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: salesData.map(item => item.revenue),
                borderColor: '#b8924a',
                borderWidth: 2,
                backgroundColor: 'rgba(184, 146, 74, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#b8924a',
                pointBorderColor: '#1e1410',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(30,20,16,0.95)',
                    titleColor: '#e8d5b0',
                    bodyColor: '#fff',
                    borderColor: 'rgba(184,146,74,0.3)',
                    borderWidth: 1,
                    padding: 10,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(184,146,74,0.05)', drawBorder: false },
                    ticks: {
                        callback: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); }
                    }
                },
                x: {
                    grid: { display: false, drawBorder: false }
                }
            }
        }
    });

    // Chart Data Config
    const last7DaysData = @json($top10Products);
    const monthData = @json($top10ProductsMonth);
    const categoryData7Days = @json($productsByCategory);
    const categoryDataMonth = @json($productsByCategoryMonth);

    let topProductsChart = null;
    let categoryChart = null;

    function initTopProductsChart() {
        const ctx2 = document.getElementById('topProductsChart').getContext('2d');
        topProductsChart = new Chart(ctx2, {
            type: 'bar',
            data: getProductsData('7days'),
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(30,20,16,0.95)',
                        borderColor: 'rgba(184,146,74,0.3)',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) { return context.parsed.x + ' terjual'; }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: 'rgba(184,146,74,0.05)' },
                        ticks: { precision: 0 }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { color: '#e8d5b0', font: { size: 11 } }
                    }
                }
            }
        });
    }

    // Custom plugin: draw % labels on donut slices
    const donutPercentPlugin = {
        id: 'donutPercent',
        afterDraw(chart) {
            const { ctx, data } = chart;
            if (chart.config.type !== 'doughnut') return;
            
            // Fix: Cast values to Number because PHP might send them as strings (causing text concatenation)
            const total = data.datasets[0].data.reduce((a, b) => Number(a) + Number(b), 0);
            if (!total) return;

            chart.getDatasetMeta(0).data.forEach((arc, i) => {
                const value = Number(data.datasets[0].data[i]);
                const pct = Math.round((value / total) * 100);
                if (pct < 5) return; // skip slices too small

                const angle = arc.startAngle + (arc.endAngle - arc.startAngle) / 2;
                const r = (arc.innerRadius + arc.outerRadius) / 2;
                const x = arc.x + Math.cos(angle) * r;
                const y = arc.y + Math.sin(angle) * r;

                ctx.save();
                ctx.font = 'bold 12px Inter, sans-serif';
                ctx.fillStyle = '#1e1410';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(pct + '%', x, y);
                ctx.restore();
            });
        }
    };

    function initCategoryChart() { initCategoryChartWithData('7days'); }

    function initCategoryChartWithData(period) {
        const ctx3 = document.getElementById('categoryChart').getContext('2d');
        categoryChart = new Chart(ctx3, {
            type: 'doughnut',
            data: getCategoryData(period),
            plugins: [donutPercentPlugin],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { color: '#f4ede3', usePointStyle: true, boxWidth: 8, padding: 15 }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30,20,16,0.95)',
                        borderColor: 'rgba(184,146,74,0.3)',
                        borderWidth: 1,
                        callbacks: {
                            label: function(ctx) {
                                return ' ' + ctx.parsed + ' terjual';
                            }
                        }
                    }
                }
            }
        });
    }

    function getProductsData(period) {
        const data = period === '7days' ? last7DaysData : monthData;
        return {
            labels: data.map(item => item.name.length > 20 ? item.name.substring(0, 20) + '...' : item.name),
            datasets: [{
                label: 'Terjual',
                data: data.map(item => item.total_sold),
                backgroundColor: 'rgba(184,146,74,0.4)',
                hoverBackgroundColor: 'rgba(184,146,74,0.8)',
                borderRadius: 4,
            }]
        };
    }

    function getCategoryData(period) {
        const data = period === '7days' ? categoryData7Days : categoryDataMonth;
        const colors = [
            '#b8924a', '#d4af7a', '#8a6e38', '#e8d5b0', '#5c4925', '#a38141'
        ];
        return {
            labels: data.map(item => item.category),
            datasets: [{
                data: data.map(item => item.total_sold),
                backgroundColor: colors,
                borderWidth: 0,
                hoverOffset: 4
            }]
        };
    }

    function switchPeriod(period) {
        const btn7 = document.getElementById('btn-7days');
        const btnMonth = document.getElementById('btn-month');
        
        if (period === '7days') {
            btn7.className = 'px-3 py-1 rounded text-xs font-medium transition-colors bg-[var(--gold)] text-[var(--black)] shadow-sm';
            btnMonth.className = 'px-3 py-1 rounded text-xs font-medium transition-colors text-[var(--gold)] hover:bg-[rgba(184,146,74,0.1)]';
            document.getElementById('chartPeriodLabel').textContent = 'Periode: 7 Hari Terakhir';
        } else {
            btnMonth.className = 'px-3 py-1 rounded text-xs font-medium transition-colors bg-[var(--gold)] text-[var(--black)] shadow-sm';
            btn7.className = 'px-3 py-1 rounded text-xs font-medium transition-colors text-[var(--gold)] hover:bg-[rgba(184,146,74,0.1)]';
            document.getElementById('chartPeriodLabel').textContent = 'Periode: {{ $periodLabel ?? now()->translatedFormat("M Y") }}';
        }
        
        if (topProductsChart) {
            topProductsChart.data = getProductsData(period);
            topProductsChart.update();
        }
        if (categoryChart) {
            categoryChart.data = getCategoryData(period);
            categoryChart.update();
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        initTopProductsChart();
        initCategoryChart();
    });
</script>
@endpush
@endsection
