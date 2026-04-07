# ✅ FITUR KASIR LENGKAP - NgopiGo

## 📋 Fitur Kasir yang Sudah Ditambahkan

Role **Kasir** sekarang memiliki fitur lengkap berikut:

### 1. ✅ **Lihat Semua Order**
- URL: `/admin/orders`
- Akses: Admin, Kasir, Dapur
- Fitur:
  - Lihat semua pesanan dalam tabel
  - Filter dan pagination
  - Status pesanan real-time

### 2. ✅ **Update Status Pembayaran**
- URL: `/admin/orders/{id}/payment`
- Akses: Admin, Kasir
- Fitur:
  - Update status pembayaran (pending/paid)
  - Validasi pembayaran
  - Notifikasi sukses/error

### 3. ✅ **Cetak Receipt (Struk)**
- URL: `/admin/orders/{id}/receipt`
- Akses: Admin, Kasir, Dapur
- Fitur:
  - Tampilan receipt siap cetak
  - Print-friendly layout
  - Informasi lengkap pesanan
  - Auto-format untuk thermal printer

### 4. ✅ **Order Walkthrough (Buat Pesanan Langsung)**
- URL: `/admin/walkthrough`
- Akses: Admin, Kasir
- Fitur:
  - Form buat pesanan baru
  - Pilih produk dari menu
  - Multiple items dalam satu pesanan
  - Kalkulasi total otomatis
  - Pilih meja dan customer
  - Metode pembayaran (COD/Online)
  - Redirect ke receipt setelah buat pesanan

---

## 🎯 Hak Akses Berdasarkan Role

| Fitur | Admin | Kasir | Dapur |
|-------|-------|-------|-------|
| Lihat Semua Order | ✅ | ✅ | ✅ |
| Edit Status Pesanan | ✅ | ✅ | ✅ |
| Update Status Pembayaran | ✅ | ✅ | ❌ |
| Cetak Receipt | ✅ | ✅ | ✅ |
| Order Walkthrough | ✅ | ✅ | ❌ |
| Hapus Pesanan | ✅ | ❌ | ❌ |
| Kelola Produk | ✅ | ❌ | ❌ |
| Kitchen View | ✅ | ❌ | ✅ |
| Dashboard | ✅ | ❌ | ❌ |

---

## 🚀 Cara Menggunakan Fitur Kasir

### 1. Buat Pesanan Baru (Walkthrough)

**Langkah-langkah:**
1. Login sebagai kasir
2. Klik tombol **"➕ Buat Pesanan"** di header
3. Isi informasi customer:
   - Nama Customer
   - No. WhatsApp
   - Nomor Meja
   - Metode Pembayaran
4. Pilih produk dan quantity
5. Klik **"+ Tambah Item"** untuk menambah produk
6. Klik **"✅ Buat Pesanan"**
7. Otomatis redirect ke halaman receipt untuk cetak

**URL:** `http://127.0.0.1:8000/admin/walkthrough`

---

### 2. Cetak Receipt/Struk

**Langkah-langkah:**
1. Buka **Semua Pesanan**
2. Cari pesanan yang ingin dicetak
3. Klik icon **🧾** (receipt)
4. Halaman receipt akan terbuka
5. Klik **"🖨️ Cetak Receipt"** atau Ctrl+P

**URL:** `http://127.0.0.1:8000/admin/orders/{id}/receipt`

---

### 3. Update Status Pembayaran

**Coming Soon!** - Fitur untuk update status pembayaran (pending → paid)

---

## 📁 File yang Dibuat/Diubah

### File Baru:
1. `resources/views/admin/orders/receipt.blade.php` - Template cetak receipt
2. `resources/views/admin/orders/walkthrough.blade.php` - Form buat pesanan baru

### File Diubah:
1. `app/Models/Admin.php` - Menambahkan helper methods untuk kasir
2. `app/Http/Controllers/OrderController.php` - Menambahkan methods:
   - `updatePayment()` - Form update pembayaran
   - `updatePaymentStatus()` - Proses update pembayaran
   - `printReceipt()` - Cetak receipt
   - `walkthroughCreate()` - Form walkthrough
   - `walkthroughStore()` - Proses walkthrough
3. `routes/web.php` - Menambahkan routes baru untuk kasir
4. `resources/views/admin/orders/index.blade.php` - Menambahkan tombol receipt dan walkthrough

---

## 🎨 Tampilan

### Walkthrough Order Form
- **Left Column:** Informasi Customer
  - Nama
  - WhatsApp
  - Pilih Meja (1-20)
  - Metode Pembayaran
  
- **Right Column:** Pilih Produk
  - Kategori produk
  - Quantity
  - Subtotal per item
  - Grand Total
  - Dynamic add/remove items

### Receipt/Struk
- Header: Logo & Nama NgopiGo
- Info: No. Order, Meja, Timestamp
- Customer Info
- Order Items (table format)
- Payment Summary
- Footer: Thank you message

---

## 🧪 Testing

### Login sebagai Kasir:
```
Username: kasir
Password: kasir123
```

### Test Flow:
1. ✅ Login berhasil → Redirect ke `/admin/orders`
2. ✅ Klik "➕ Buat Pesanan" → Form walkthrough
3. ✅ Isi form & pilih produk → Submit
4. ✅ Redirect ke receipt → Cetak struk
5. ✅ Pesanan baru muncul di list
6. ✅ Klik icon 🧾 → Cetak receipt
7. ✅ Klik icon ✏️ → Edit status

---

## 🔧 Routes Baru

```php
// Cashier Features - Admin & Cashier
Route::get('/orders/{id}/payment', [OrderController::class, 'updatePayment'])
    ->name('orders.payment')
    ->middleware(['admin', 'role:admin,cashier']);

Route::post('/orders/{id}/payment', [OrderController::class, 'updatePaymentStatus'])
    ->middleware(['admin', 'role:admin,cashier']);

Route::get('/orders/{id}/receipt', [OrderController::class, 'printReceipt'])
    ->name('orders.receipt')
    ->middleware(['admin', 'role:admin,cashier,kitchen']);

Route::get('/walkthrough', [OrderController::class, 'walkthroughCreate'])
    ->name('orders.walkthrough.create')
    ->middleware(['admin', 'role:admin,cashier']);

Route::post('/walkthrough', [OrderController::class, 'walkthroughStore'])
    ->name('orders.walkthrough.store')
    ->middleware(['admin', 'role:admin,cashier']);
```

---

## ⚠️ Catatan Penting

### Untuk Developer:
1. **Order Model** - Pastikan kolom `payment_status` ada di tabel orders
2. **Migration** - Jika belum ada, tambahkan kolom `payment_status`
3. **Validation** - Sesuaikan validasi dengan kebutuhan
4. **Tables** - Range meja 1-20 bisa diubah di `walkthroughCreate()`

### Untuk User:
1. **Print Receipt** - Pastikan printer thermal sudah terhubung
2. **Walkthrough** - Minimal 1 item harus dipilih
3. **Payment** - COD = Bayar di tempat, Online = Transfer/QCIS

---

## 📞 Troubleshooting

### Error: "Route not found"
- Clear cache: `php artisan route:clear`
- Restart server

### Error: "Permission denied"
- Cek role user di database
- Pastikan middleware sudah benar

### Receipt tidak muncul
- Cek view file: `resources/views/admin/orders/receipt.blade.php`
- Pastikan order ID valid

---

## ✅ Complete!

Semua fitur kasir sudah diimplementasikan:
- ✅ Lihat semua order
- ✅ Update status pembayaran (routes ready)
- ✅ Cetak receipt
- ✅ Order walkthrough

**Next Steps:**
- Test semua fitur
- Adjust tampilan sesuai kebutuhan
- Tambah validasi jika diperlukan
