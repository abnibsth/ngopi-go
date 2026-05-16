@extends('admin.layouts.app')

@section('title', 'Kelola Produk')

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
        box-shadow: 0 12px 30px rgba(0,0,0,0.5), 0 0 0 1px rgba(184,146,74,0.3);
        background: rgba(30,20,16,0.8);
    }
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
    .status-pill {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.2rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 500;
        border: 1px solid transparent;
    }
</style>
@endpush

@section('content')
<div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold gradient-gold flex items-center gap-3">
            <svg class="w-8 h-8 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
            </svg>
            Kelola Produk
        </h1>
        <p class="text-[var(--gold)]/70 mt-1 text-sm tracking-wide">Tambah, edit, atau hapus menu restoran</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-[var(--gold)] to-[var(--gold-light)] hover:from-[var(--gold-light)] hover:to-[var(--gold)] text-[var(--black)] font-semibold py-2 px-4 rounded-lg transition-all shadow-[0_4px_12px_rgba(184,146,74,0.2)] hover:shadow-[0_6px_16px_rgba(184,146,74,0.3)] hover:-translate-y-0.5 text-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah Produk
    </a>
</div>

<div class="premium-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left premium-table">
            <thead>
                <tr>
                    <th class="px-5 py-4">Menu</th>
                    <th class="px-5 py-4">Kategori</th>
                    <th class="px-5 py-4">Harga</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="transition-colors group">
                    <td class="px-5 py-4 border-b border-[rgba(184,146,74,0.05)]">
                        <div class="flex items-center gap-4">
                            @if($product->image)
                            <div class="relative w-14 h-14 rounded-lg overflow-hidden border border-[rgba(184,146,74,0.2)] shadow-sm group-hover:border-[rgba(184,146,74,0.4)] transition-colors">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            </div>
                            @else
                            <div class="w-14 h-14 bg-[rgba(184,146,74,0.05)] rounded-lg flex items-center justify-center border border-[rgba(184,146,74,0.2)]">
                                <svg class="w-6 h-6 text-[var(--gold)]/40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-white truncate">{{ $product->name }}</p>
                                <p class="text-xs text-[var(--gold)]/60 truncate max-w-[200px] mt-0.5" title="{{ $product->description }}">{{ $product->description }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 border-b border-[rgba(184,146,74,0.05)] whitespace-nowrap">
                        <span class="px-2.5 py-1 rounded text-xs font-medium border
                            @if($product->category === 'coffee') bg-[rgba(184,146,74,0.1)] text-[var(--gold)] border-[rgba(184,146,74,0.2)]
                            @elseif($product->category === 'non-coffee') bg-[rgba(96,165,250,0.1)] text-[#60a5fa] border-[rgba(96,165,250,0.2)]
                            @elseif($product->category === 'food') bg-[rgba(251,146,60,0.1)] text-[#fb923c] border-[rgba(251,146,60,0.2)]
                            @else bg-[rgba(253,224,71,0.1)] text-[#fde047] border-[rgba(253,224,71,0.2)]
                            @endif">
                            {{ ucfirst($product->category) }}
                        </span>
                    </td>
                    <td class="px-5 py-4 border-b border-[rgba(184,146,74,0.05)] whitespace-nowrap">
                        @if($product->discount_price && $product->discount_price > 0)
                            <div class="flex flex-col">
                                <span class="text-xs text-white/40 line-through decoration-red-500/50 decoration-2">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="font-bold gradient-gold">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <span class="font-bold gradient-gold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 border-b border-[rgba(184,146,74,0.05)] whitespace-nowrap">
                        <span class="status-pill
                            @if($product->is_available) bg-[rgba(74,222,128,0.1)] text-[#4ade80] border border-[rgba(74,222,128,0.2)]
                            @else bg-[rgba(248,113,113,0.1)] text-[#f87171] border border-[rgba(248,113,113,0.2)]
                            @endif">
                            @if($product->is_available)
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                Tersedia
                            @else
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                Habis
                            @endif
                        </span>
                    </td>
                    <td class="px-5 py-4 border-b border-[rgba(184,146,74,0.05)] whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                               class="w-8 h-8 rounded-lg bg-[rgba(96,165,250,0.1)] text-[#60a5fa] border border-[rgba(96,165,250,0.2)] hover:bg-[rgba(96,165,250,0.2)] flex items-center justify-center transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="if(confirm('Hapus produk ini secara permanen?')) this.closest('form').submit()"
                                        class="w-8 h-8 rounded-lg bg-[rgba(248,113,113,0.1)] text-[#f87171] border border-[rgba(248,113,113,0.2)] hover:bg-[rgba(248,113,113,0.2)] flex items-center justify-center transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-[var(--gold)]/50 text-sm border-b border-[rgba(184,146,74,0.05)]">
                        <div class="flex flex-col items-center justify-center gap-3">
                            <svg class="w-10 h-10 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                            <div>
                                <p class="font-medium text-white mb-1">Belum ada produk</p>
                                <a href="{{ route('admin.products.create') }}" class="text-[var(--gold)] hover:text-[var(--gold-light)] underline transition-colors">Tambah produk pertama</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($products->hasPages())
<div class="mt-6">
    {{ $products->links() }}
</div>
@endif
@endsection
