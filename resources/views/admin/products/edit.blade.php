<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - NgopiGo</title>
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
    </style>
</head>
<body class="bg-premium-black min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] border-b border-[#C69C6D]/30 shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold gradient-gold">✏️ Edit Produk</h1>
                    <p class="text-[#C69C6D] mt-1">{{ $product->name }}</p>
                </div>
                <a href="{{ route('admin.products.index') }}"
                   class="bg-[#C69C6D]/20 hover:bg-[#C69C6D]/40 border border-[#C69C6D]/50 text-[#F5F0E6] font-semibold py-2 px-4 rounded-lg transition backdrop-blur-sm">
                    ← Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-[#1a120f] rounded-xl shadow-xl p-8 border border-[#C69C6D]/20">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-[#F5F0E6] mb-2">Nama Produk <span class="text-[#f87171]">*</span></label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $product->name) }}"
                               required
                               class="w-full px-4 py-3 border-2 border-[#C69C6D]/30 rounded-lg bg-[#2E1F1A] text-[#F5F0E6] placeholder-[#C69C6D]/50 focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition @error('name') border-[#f87171] @enderror"
                               placeholder="Contoh: Espresso">
                        @error('name')
                        <p class="text-[#f87171] text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-[#F5F0E6] mb-2">Deskripsi</label>
                        <textarea name="description"
                                  id="description"
                                  rows="3"
                                  class="w-full px-4 py-3 border-2 border-[#C69C6D]/30 rounded-lg bg-[#2E1F1A] text-[#F5F0E6] placeholder-[#C69C6D]/50 focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition @error('description') border-[#f87171] @enderror"
                                  placeholder="Deskripsi produk...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                        <p class="text-[#f87171] text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category and Price -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="category" class="block text-sm font-medium text-[#F5F0E6] mb-2">Kategori <span class="text-[#f87171]">*</span></label>
                            <select name="category"
                                    id="category"
                                    required
                                    class="w-full px-4 py-3 border-2 border-[#C69C6D]/30 rounded-lg bg-[#2E1F1A] text-[#F5F0E6] focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition @error('category') border-[#f87171] @enderror">
                                <option value="">Pilih Kategori</option>
                                <option value="coffee" {{ old('category', $product->category) === 'coffee' ? 'selected' : '' }}>☕ Kopi</option>
                                <option value="non-coffee" {{ old('category', $product->category) === 'non-coffee' ? 'selected' : '' }}>🍵 Non Kopi</option>
                                <option value="food" {{ old('category', $product->category) === 'food' ? 'selected' : '' }}>🍛 Makanan</option>
                                <option value="snack" {{ old('category', $product->category) === 'snack' ? 'selected' : '' }}>🍟 Snack</option>
                            </select>
                            @error('category')
                            <p class="text-[#f87171] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-[#F5F0E6] mb-2">Harga (Rp) <span class="text-[#f87171]">*</span></label>
                            <input type="number"
                                   name="price"
                                   id="price"
                                   value="{{ old('price', $product->price) }}"
                                   required
                                   min="0"
                                   class="w-full px-4 py-3 border-2 border-[#C69C6D]/30 rounded-lg bg-[#2E1F1A] text-[#F5F0E6] placeholder-[#C69C6D]/50 focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition @error('price') border-[#f87171] @enderror"
                                   placeholder="25000">
                            @error('price')
                            <p class="text-[#f87171] text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-[#F5F0E6] mb-2">Foto Produk</label>
                        @if($product->image)
                        <div class="mb-4">
                            <p class="text-sm text-[#C69C6D] mb-2">Foto saat ini:</p>
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-32 h-32 object-cover rounded-lg border-2 border-[#C69C6D]/30">
                        </div>
                        @endif
                        <input type="file"
                               name="image"
                               id="image"
                               accept="image/*"
                               class="w-full px-4 py-3 border-2 border-[#C69C6D]/30 rounded-lg bg-[#2E1F1A] text-[#F5F0E6] focus:ring-2 focus:ring-[#C69C6D] focus:border-transparent transition @error('image') border-[#f87171] @enderror"
                               onchange="previewImage(event)">
                        @error('image')
                        <p class="text-[#f87171] text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <div id="imagePreview" class="mt-4 hidden">
                            <p class="text-sm text-[#C69C6D] mb-2">Foto baru:</p>
                            <img id="preview" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border-2 border-[#C69C6D]/30">
                        </div>
                    </div>

                    <!-- Availability -->
                    <div class="mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox"
                                   name="is_available"
                                   value="1"
                                   {{ old('is_available', $product->is_available) ? 'checked' : '' }}
                                   class="w-5 h-5 text-[#C69C6D] border-[#C69C6D]/30 rounded focus:ring-[#C69C6D] bg-[#2E1F1A]">
                            <span class="ml-2 text-[#F5F0E6]">Produk tersedia untuk dipesan</span>
                        </label>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="flex-1 bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] hover:from-[#D4AF7A] hover:to-[#C69C6D] text-[#121212] font-bold py-3 px-6 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200">
                            💾 Update Produk
                        </button>
                        <a href="{{ route('admin.products.index') }}"
                           class="px-6 py-3 border-2 border-[#C69C6D]/30 text-[#F5F0E6] font-semibold rounded-lg hover:bg-[#2E1F1A] transition text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
