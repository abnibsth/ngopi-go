@extends('admin.layouts.app')

@section('title', 'Buat Pesanan Baru')

@push('styles')
<style>
    .premium-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .premium-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(198, 156, 109, 0.2);
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold gradient-gold">🛒 Buat Pesanan Baru</h2>
            <p class="text-[#C69C6D] mt-1">Input pesanan customer secara langsung</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" 
           class="bg-[#C69C6D]/20 hover:bg-[#C69C6D]/40 border border-[#C69C6D]/50 text-[#F5F0E6] font-semibold py-2 px-4 rounded-lg transition backdrop-blur-sm">
            ← Kembali ke Pesanan
        </a>
    </div>
</div>

@if($errors->any())
<div class="bg-red-900/50 border border-red-500/50 text-red-200 px-6 py-4 rounded-xl mb-6">
    <p class="font-bold mb-2">⚠️ Terdapat kesalahan:</p>
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.orders.walkthrough.store') }}" method="POST">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Customer Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Customer Information Card -->
            <div class="bg-[#1a120f] rounded-xl shadow-xl overflow-hidden border border-[#C69C6D]/20 premium-card">
                <div class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] px-6 py-4 border-b border-[#C69C6D]/20">
                    <h3 class="text-lg font-bold text-[#F5F0E6]">👤 Informasi Customer</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-[#C69C6D] mb-2">
                            Nama Customer *
                        </label>
                        <input type="text" 
                               name="customer_name" 
                               id="customer_name"
                               value="{{ old('customer_name') }}"
                               required
                               class="w-full px-4 py-2 bg-[#2E1F1A] border border-[#C69C6D]/30 text-[#F5F0E6] rounded-lg focus:outline-none focus:border-[#C69C6D] focus:ring-2 focus:ring-[#C69C6D]/20 transition">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-[#C69C6D] mb-2">
                            No. WhatsApp *
                        </label>
                        <input type="text" 
                               name="phone" 
                               id="phone"
                               value="{{ old('phone') }}"
                               required
                               placeholder="08xxxxxxxxxx"
                               class="w-full px-4 py-2 bg-[#2E1F1A] border border-[#C69C6D]/30 text-[#F5F0E6] rounded-lg focus:outline-none focus:border-[#C69C6D] focus:ring-2 focus:ring-[#C69C6D]/20 transition">
                    </div>
                    
                    <div>
                        <label for="table_number" class="block text-sm font-medium text-[#C69C6D] mb-2">
                            Nomor Meja *
                        </label>
                        <select name="table_number" 
                                id="table_number"
                                required
                                class="w-full px-4 py-2 bg-[#2E1F1A] border border-[#C69C6D]/30 text-[#F5F0E6] rounded-lg focus:outline-none focus:border-[#C69C6D] focus:ring-2 focus:ring-[#C69C6D]/20 transition">
                            <option value="">Pilih Meja</option>
                            @foreach($tables as $table)
                            <option value="{{ $table }}" {{ old('table_number') == $table ? 'selected' : '' }}>
                                Meja {{ $table }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-[#C69C6D] mb-2">
                            Metode Pembayaran *
                        </label>
                        <select name="payment_method" 
                                id="payment_method"
                                required
                                class="w-full px-4 py-2 bg-[#2E1F1A] border border-[#C69C6D]/30 text-[#F5F0E6] rounded-lg focus:outline-none focus:border-[#C69C6D] focus:ring-2 focus:ring-[#C69C6D]/20 transition">
                            <option value="">Pilih Pembayaran</option>
                            <option value="cod" {{ old('payment_method') === 'cod' ? 'selected' : '' }}>💵 COD (Bayar di Tempat)</option>
                            <option value="online" {{ old('payment_method') === 'online' ? 'selected' : '' }}>💳 Online Payment</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Order Items -->
        <div class="lg:col-span-2">
            <div class="bg-[#1a120f] rounded-xl shadow-xl overflow-hidden border border-[#C69C6D]/20 premium-card">
                <div class="bg-gradient-to-r from-[#2E1F1A] to-[#1a120f] px-6 py-4 border-b border-[#C69C6D]/20">
                    <h3 class="text-lg font-bold text-[#F5F0E6]">📦 Pilih Produk</h3>
                </div>
                <div class="p-6">
                    <!-- Order Items Container -->
                    <div id="order-items" class="space-y-4">
                        <div class="item-row grid grid-cols-12 gap-4 items-end">
                            <div class="col-span-6">
                                <label class="block text-xs font-medium text-[#C69C6D] mb-2">Produk</label>
                                <select name="items[0][product_id]" 
                                        required
                                        class="product-select w-full px-4 py-2 bg-[#2E1F1A] border border-[#C69C6D]/30 text-[#F5F0E6] rounded-lg focus:outline-none focus:border-[#C69C6D] transition">
                                    <option value="">Pilih Produk</option>
                                    @foreach($products as $category => $productList)
                                        <optgroup label="{{ $category }}">
                                            @foreach($productList as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-3">
                                <label class="block text-xs font-medium text-[#C69C6D] mb-2">Qty</label>
                                <input type="number" 
                                       name="items[0][quantity]" 
                                       value="1" 
                                       min="1" 
                                       required
                                       class="quantity-input w-full px-4 py-2 bg-[#2E1F1A] border border-[#C69C6D]/30 text-[#F5F0E6] rounded-lg focus:outline-none focus:border-[#C69C6D] transition">
                            </div>
                            <div class="col-span-3">
                                <label class="block text-xs font-medium text-[#C69C6D] mb-2">Subtotal</label>
                                <div class="subtotal text-[#C69C6D] font-semibold">Rp 0</div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Item Button -->
                    <button type="button" 
                            id="add-item-btn"
                            class="mt-4 w-full py-3 bg-[#C69C6D]/20 hover:bg-[#C69C6D]/40 border border-[#C69C6D]/50 text-[#C69C6D] font-semibold rounded-lg transition dashed border-dashed">
                        + Tambah Item
                    </button>

                    <!-- Total Section -->
                    <div class="mt-6 pt-6 border-t border-[#C69C6D]/20">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-[#C69C6D]">Total Pembayaran</span>
                            <span id="grand-total" class="text-3xl font-bold gradient-gold">Rp 0</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit" 
                                class="w-full py-4 bg-gradient-to-r from-[#C69C6D] to-[#D4AF7A] hover:from-[#D4AF7A] hover:to-[#C69C6D] text-[#121212] font-bold rounded-xl shadow-lg hover:shadow-[#C69C6D]/50 transform hover:scale-[1.02] transition-all duration-200 text-lg">
                            ✅ Buat Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
let itemCount = 1;

// Calculate subtotal for a row
function calculateSubtotal(row) {
    const productSelect = row.querySelector('.product-select');
    const quantityInput = row.querySelector('.quantity-input');
    const subtotalDiv = row.querySelector('.subtotal');
    
    const price = parseInt(productSelect.selectedOptions[0]?.dataset.price || 0);
    const quantity = parseInt(quantityInput.value) || 1;
    const subtotal = price * quantity;
    
    subtotalDiv.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    return subtotal;
}

// Calculate grand total
function calculateGrandTotal() {
    let total = 0;
    document.querySelectorAll('#order-items .item-row').forEach(row => {
        total += calculateSubtotal(row);
    });
    document.getElementById('grand-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

// Add new item row
document.getElementById('add-item-btn').addEventListener('click', function() {
    const container = document.getElementById('order-items');
    const newRow = document.createElement('div');
    newRow.className = 'item-row grid grid-cols-12 gap-4 items-end mt-4';
    newRow.innerHTML = `
        <div class="col-span-6">
            <label class="block text-xs font-medium text-[#C69C6D] mb-2">Produk</label>
            <select name="items[${itemCount}][product_id]" 
                    required
                    class="product-select w-full px-4 py-2 bg-[#2E1F1A] border border-[#C69C6D]/30 text-[#F5F0E6] rounded-lg focus:outline-none focus:border-[#C69C6D] transition">
                <option value="">Pilih Produk</option>
                @foreach($products as $category => $productList)
                    <optgroup label="{{ $category }}">
                        @foreach($productList as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                        </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
        <div class="col-span-3">
            <label class="block text-xs font-medium text-[#C69C6D] mb-2">Qty</label>
            <input type="number" 
                   name="items[${itemCount}][quantity]" 
                   value="1" 
                   min="1" 
                   required
                   class="quantity-input w-full px-4 py-2 bg-[#2E1F1A] border border-[#C69C6D]/30 text-[#F5F0E6] rounded-lg focus:outline-none focus:border-[#C69C6D] transition">
        </div>
        <div class="col-span-2">
            <label class="block text-xs font-medium text-[#C69C6D] mb-2">Subtotal</label>
            <div class="subtotal text-[#C69C6D] font-semibold">Rp 0</div>
        </div>
        <div class="col-span-1">
            <button type="button" class="remove-btn w-full py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                🗑️
            </button>
        </div>
    `;
    
    container.appendChild(newRow);
    
    // Add event listeners to new row
    newRow.querySelector('.product-select').addEventListener('change', () => {
        calculateSubtotal(newRow);
        calculateGrandTotal();
    });
    
    newRow.querySelector('.quantity-input').addEventListener('input', () => {
        calculateSubtotal(newRow);
        calculateGrandTotal();
    });
    
    newRow.querySelector('.remove-btn').addEventListener('click', function() {
        if (document.querySelectorAll('#order-items .item-row').length > 1) {
            newRow.remove();
            calculateGrandTotal();
        } else {
            alert('Minimal harus ada 1 item');
        }
    });
    
    itemCount++;
});

// Initial event listeners
document.querySelectorAll('.product-select').forEach(select => {
    select.addEventListener('change', calculateGrandTotal);
});

document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('input', calculateGrandTotal);
});

document.querySelectorAll('.remove-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        if (document.querySelectorAll('#order-items .item-row').length > 1) {
            this.closest('.item-row').remove();
            calculateGrandTotal();
        } else {
            alert('Minimal harus ada 1 item');
        }
    });
});

// Initial calculation
calculateGrandTotal();
</script>
@endpush
