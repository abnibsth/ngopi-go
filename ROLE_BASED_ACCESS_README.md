# 📋 Cara Mengaktifkan Sistem Role-Based Access Control

## 🎯 Ringkasan Perubahan

Sistem sekarang memiliki **3 role** dengan akses berbeda:

### 👑 **ADMIN** (admin / admin123)
- ✅ Dashboard Admin
- ✅ Kelola Pesanan
- ✅ Kelola Dapur (Kitchen View)
- ✅ Kelola Produk
- ✅ Riwayat Pesanan

### 🍳 **DAPUR** (dapur / dapur123)
- ✅ Kitchen View (lihat pesanan aktif)
- ✅ Riwayat Pesanan
- ❌ Dashboard Admin
- ❌ Kelola Produk
- ❌ Kelola Pesanan (edit/delete)

### 💵 **KASIR** (kasir / kasir123)
- ✅ Kelola Pesanan (lihat & edit status)
- ✅ Riwayat Pesanan
- ❌ Dashboard Admin
- ❌ Kelola Produk
- ❌ Kitchen View

---

## 🔧 Langkah Instalasi

### 1. **Jalankan Migration**
Tambahkan kolom `role` ke tabel `admins`:

```sql
-- Cara manual di phpMyAdmin:
ALTER TABLE admins ADD COLUMN role VARCHAR(50) DEFAULT 'admin' AFTER name;
```

Atau gunakan file migration yang sudah dibuat:
```bash
# Jika composer bisa dijalankan (PHP 8.3+)
php artisan migrate
```

### 2. **Update Data Admin yang Sudah Ada**
Jalankan SQL script untuk set role pada user yang sudah ada:

```sql
-- File: update-admin-roles.sql
UPDATE admins SET role = 'admin' WHERE username = 'admin';
UPDATE admins SET role = 'cashier' WHERE username = 'kasir';
```

Atau via phpMyAdmin:
1. Buka http://localhost/phpmyadmin
2. Pilih database `ngopigo`
3. Klik tab "SQL"
4. Copy-paste query di atas
5. Klik "Go"

### 3. **Jalankan AdminSeeder (Opsional - Untuk Reset)**
Jika ingin membuat ulang user dengan role yang benar:

```bash
# Jika composer bisa dijalankan
php artisan db:seed --class=AdminSeeder
```

Atau jalankan manual via SQL:
```sql
-- Hapus data lama (opsional)
DELETE FROM admins;

-- Insert user baru dengan role
INSERT INTO admins (username, email, password, name, role, is_active, created_at, updated_at) 
VALUES 
('admin', 'admin@ngopigo.com', '$2y$12$...hash...', 'Administrator', 'admin', 1, NOW(), NOW()),
('dapur', 'dapur@ngopigo.com', '$2y$12$...hash...', 'Staff Dapur', 'kitchen', 1, NOW(), NOW()),
('kasir', 'kasir@ngopigo.com', '$2y$12$...hash...', 'Kasir NgopiGo', 'cashier', 1, NOW(), NOW());
```

---

## 🚪 Login Credentials

| Role | Username | Password | Akses Utama |
|------|----------|----------|-------------|
| **Admin** | `admin` | `admin123` | Full Access |
| **Dapur** | `dapur` | `dapur123` | Kitchen & History |
| **Kasir** | `kasir` | `kasir123` | Orders & History |

---

## 📁 File yang Dibuat/Diubah

### File Baru:
- `database/migrations/2026_04_06_000001_add_role_to_admins_table.php`
- `app/Http/Middleware/RoleMiddleware.php`
- `resources/views/admin/layouts/app.blade.php`
- `resources/views/admin/history.blade.php`
- `update-admin-roles.sql`

### File Diubah:
- `app/Models/Admin.php` - Menambahkan role helpers
- `database/seeders/AdminSeeder.php` - 3 role berbeda
- `bootstrap/app.php` - Register middleware
- `routes/web.php` - Role-based routes
- `app/Http/Controllers/OrderController.php` - Method history()

---

## 🎨 Fitur Berdasarkan Role

### Admin Dashboard
- Statistik penjualan lengkap
- Total pendapatan
- Jumlah pesanan aktif
- Grafik penjualan

### Kitchen View
- Daftar pesanan aktif (pending, preparing, ready)
- Update status pesanan
- Tampilan card untuk mudah dibaca

### Orders Management (Admin & Kasir)
- Lihat semua pesanan
- Edit status pesanan
- Hapus pesanan (Admin only)

### History (Semua Role)
- Riwayat pesanan selesai
- Riwayat pesanan dibatalkan
- Statistik total pendapatan

---

## 🔒 Middleware & Routes

Middleware `role` sudah terdaftar dan bisa digunakan seperti ini:

```php
// Admin only
Route::get('/admin', ...)->middleware('role:admin');

// Admin atau Kasir
Route::get('/orders', ...)->middleware('role:admin,cashier');

// Admin atau Dapur
Route::get('/kitchen', ...)->middleware('role:admin,kitchen');

// Semua role
Route::get('/history', ...)->middleware('role:admin,kitchen,cashier');
```

---

## ✅ Testing

1. **Login sebagai Admin**
   - URL: http://localhost/ngopi-go/admin/login
   - Username: `admin`
   - Password: `admin123`
   - Harusnya bisa akses semua menu

2. **Login sebagai Dapur**
   - URL: http://localhost/ngopi-go/admin/login
   - Username: `dapur`
   - Password: `dapur123`
   - Harusnya hanya bisa akses: Kitchen & Riwayat

3. **Login sebagai Kasir**
   - URL: http://localhost/ngopi-go/admin/login
   - Username: `kasir`
   - Password: `kasir123`
   - Harusnya hanya bisa akses: Pesanan & Riwayat

---

## ⚠️ Troubleshooting

### Error: "Unauthorized access"
- Pastikan user sudah login
- Cek role user di database
- Pastikan middleware sudah terdaftar

### Error: "Column 'role' not found"
- Jalankan migration untuk tambah kolom role
- Atau tambahkan manual via phpMyAdmin

### Menu tidak muncul
- Clear cache: `php artisan cache:clear`
- Clear view cache: `php artisan view:clear`
- Refresh browser (Ctrl+F5)

---

## 📞 Support

Jika ada masalah, periksa:
1. Log file di `storage/logs/laravel.log`
2. Database sudah benar
3. Migration sudah dijalankan
4. Middleware sudah terdaftar
