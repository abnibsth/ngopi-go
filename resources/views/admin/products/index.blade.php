<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - NgopiGo</title>
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom Premium Colors - Same as Landing Page */
        :root {
            --black: #121212;
            --dark-brown: #2E1F1A;
            --gold: #C69C6D;
            --gold-light: #D4AF7A;
            --cream: #F5F0E6;
        }

        .bg-premium-black { background-color: var(--black); }
        .bg-premium-brown { background-color: var(--dark-brown); }
        .bg-premium-gold { background-color: var(--gold); }
        .text-premium-gold { color: var(--gold); }
        .border-premium-gold { border-color: var(--gold); }

        /* Gradient Text */
        .gradient-gold {
            background: linear-gradient(135deg, #C69C6D 0%, #F5DEB3 50%, #C69C6D 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Premium Card */
        .premium-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .premium-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(198, 156, 109, 0.2);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--dark-brown);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold-light);
        }
    </style>
</head>
<body class="bg-premium-black text-[#F5F0E6] min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] border-b border-[#C69C6D]/30 shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold gradient-gold">📦 Kelola Produk</h1>
                    <p class="text-[#C69C6D] mt-1">Tambah, edit, atau hapus menu</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-white text-sm">
                        <span class="text-[#C69C6D]">Halo,</span>
                        <span class="font-semibold ml-1 text-[#F5F0E6]">{{ auth()->guard('admin')->user()->name }}</span>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-[#C69C6D] hover:bg-[#D4AF7A] text-[#121212] font-semibold py-2 px-4 rounded-lg transition text-sm shadow-lg hover:shadow-[#C69C6D]/50">
                            🚪 Logout
                        </button>
                    </form>
                    <a href="{{ route('admin.kitchen') }}"
                       class="bg-[#C69C6D]/20 hover:bg-[#C69C6D]/40 border border-[#C69C6D]/50 text-[#F5F0E6] font-semibold py-2 px-4 rounded-lg transition backdrop-blur-sm">
                        👨‍🍳 Dapur
                    </a>
                    <a href="{{ route('admin.orders.index') }}"
                       class="bg-[#C69C6D]/20 hover:bg-[#C69C6D]/40 border border-[#C69C6D]/50 text-[#F5F0E6] font-semibold py-2 px-4 rounded-lg transition backdrop-blur-sm">
                        📋 Semua Pesanan
                    </a>
                    <a href="{{ route('admin.products.create') }}"
                       class="bg-[#C69C6D] hover:bg-[#D4AF7A] text-[#121212] font-semibold py-2 px-4 rounded-lg transition shadow-lg hover:shadow-[#C69C6D]/50">
                        ➕ Tambah Produk
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
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
    </main>
</body>
</html>
