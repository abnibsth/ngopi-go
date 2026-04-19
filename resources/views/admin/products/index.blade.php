@extends('admin.layouts.app')

@section('title', 'Kelola Produk')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold gradient-gold">📦 Kelola Produk</h1>
        <p class="text-[#C69C6D] mt-1">Tambah, edit, atau hapus menu</p>
    </div>

    @if(session('success'))
    <div class="bg-[#1a2f1a] border border-[#4ade80]/50 text-[#4ade80] px-4 py-3 rounded-lg mb-6 shadow-lg">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-[#1a120f] rounded-xl shadow-xl overflow-hidden border border-[#C69C6D]/20 premium-card">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#C69C6D]/20">
                <thead class="bg-[#2E1F1A]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase">Gambar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase">Nama Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#C69C6D] uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-[#1a120f] divide-y divide-[#C69C6D]/10">
                    @forelse($products as $product)
                    <tr class="hover:bg-[#2E1F1A]/50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-16 h-16 object-cover rounded-lg border border-[#C69C6D]/30">
                            @else
                            <div class="w-16 h-16 bg-[#2E1F1A] rounded-lg flex items-center justify-center border border-[#C69C6D]/30">
                                <span class="text-2xl">📷</span>
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-[#F5F0E6]">{{ $product->name }}</p>
                                <p class="text-sm text-[#C69C6D] truncate max-w-xs">{{ $product->description }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-medium border
                                @if($product->category === 'coffee') bg-[#2f261a] text-[#fbbf24] border-[#fbbf24]/30
                                @elseif($product->category === 'non-coffee') bg-[#1a2330] text-[#60a5fa] border-[#60a5fa]/30
                                @elseif($product->category === 'food') bg-[#2f1f1a] text-[#fb923c] border-[#fb923c]/30
                                @else bg-[#2f2a1a] text-[#fde047] border-[#fde047]/30
                                @endif">
                                {{ ucfirst($product->category) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-bold gradient-gold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-medium border
                                @if($product->is_available) bg-[#1a2f1a] text-[#4ade80] border-[#4ade80]/30
                                @else bg-[#2f1a1a] text-[#f87171] border-[#f87171]/30
                                @endif">
                                @if($product->is_available)
                                    ✓ Tersedia
                                @else
                                    ✕ Habis
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                               class="text-[#60a5fa] hover:text-[#93c5fd] mr-3 transition">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        onclick="if(confirm('Hapus produk ini?')) this.closest('form').submit()"
                                        class="text-[#f87171] hover:text-[#fca5a5] transition">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-[#C69C6D]">
                            📭 Belum ada produk. <a href="{{ route('admin.products.create') }}" class="text-[#4ade80] hover:underline">Tambah produk pertama</a>
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
