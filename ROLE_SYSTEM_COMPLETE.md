# 🎭 Sistem Role-Based Access Control - NgopiGo

## ✅ Selesai! Sistem Role-Based Access Control Sudah Siap

Sistem sudah diimplementasikan dengan 3 role yang memiliki akses berbeda.

---

## 👥 3 Role yang Tersedia

### 👑 **ADMIN** 
**Login:** `admin` / `admin123`

**Akses:**
- ✅ Dashboard (Statistik lengkap)
- ✅ Kelola Pesanan (CRUD)
- ✅ Kitchen View (Dapur)
- ✅ Kelola Produk (CRUD)
- ✅ Riwayat Pesanan

**Menu yang tampil:**
- 📊 Dashboard
- 📝 Pesanan
- 🍳 Dapur
- 📦 Produk
- 📜 Riwayat

---

### 🍳 **DAPUR (Kitchen)**
**Login:** `dapur` / `dapur123`

**Akses:**
- ✅ Kitchen View (lihat & update status pesanan)
- ✅ Riwayat Pesanan
- ❌ Dashboard (tidak bisa akses)
- ❌ Kelola Produk (tidak bisa akses)
- ❌ Kelola Pesanan (tidak bisa edit/delete)

**Menu yang tampil:**
- 🍳 Dapur
- 📜 Riwayat

---

### 💵 **KASIR (Cashier)**
**Login:** `kasir` / `kasir123`

**Akses:**
- ✅ Kelola Pesanan (lihat & update status)
- ✅ Riwayat Pesanan
- ❌ Dashboard (tidak bisa akses)
- ❌ Kelola Produk (tidak bisa akses)
- ❌ Kitchen View (tidak bisa akses)

**Menu yang tampil:**
- 📝 Pesanan
- 📜 Riwayat

---

## 🚀 Cara Mengaktifkan

### Langkah 1: Jalankan SQL Script

Buka phpMyAdmin: http://localhost/phpmyadmin

1. Pilih database: `ngopigo`
2. Klik tab "SQL"
3. Copy-paste script berikut:

```sql
-- Tambah kolom role
ALTER TABLE admins ADD COLUMN IF NOT EXISTS role VARCHAR(50) DEFAULT 'admin' AFTER name;

-- Update user existing
UPDATE admins SET role = 'admin' WHERE username = 'admin';
UPDATE admins SET role = 'cashier' WHERE username = 'kasir';

-- Tambah user dapur baru
INSERT INTO admins (username, email, password, name, role, is_active, created_at, updated_at)
SELECT 'dapur', 'dapur@ngopigo.com', '$2y$10$zY06QG47MnH5ogLQpHhoru6psD/skCPenXXfjSAMdUzEQHGe8v5/u', 'Staff Dapur', 'kitchen', 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM admins WHERE username = 'dapur');

-- Update password semua user
UPDATE admins SET password = '$2y$10$x0AJmxjYA1OgnNQDIJIKjO5CCToYro.ClBTGEaoCDxCjiCn7Wj7SK' WHERE username = 'admin';
UPDATE admins SET password = '$2y$10$7IYadYx70isaZ.DQMbR2QuDlqFtfsAKPzUiM9/jf/glhGLQ.Jy29a' WHERE username = 'dapur';
UPDATE admins SET password = '$2y$10$ag1uzJLT73wNGxsiFKd3Yew.vI.xj7YsqQ.6hOwAt1urZUG1Wmrg.' WHERE username = 'kasir';

-- Verifikasi
SELECT id, username, email, name, role, is_active FROM admins ORDER BY role;
```

4. Klik "Go" atau "Jalankan"

---

### Langkah 2: Test Login

#### Test sebagai Admin:
1. Buka: http://localhost/ngopi-go/admin/login
2. Login dengan: `admin` / `admin123`
3. ✅ Harusnya bisa akses semua menu

#### Test sebagai Dapur:
1. Logout dari admin
2. Login dengan: `dapur` / `dapur123`
3. ✅ Harusnya hanya bisa akses: Dapur & Riwayat
4. ❌ Jika coba akses Dashboard → Error 403

#### Test sebagai Kasir:
1. Logout dari dapur
2. Login dengan: `kasir` / `kasir123`
3. ✅ Harusnya hanya bisa akses: Pesanan & Riwayat
4. ❌ Jika coba akses Dapur → Error 403

---

## 📁 File yang Dibuat/Diubah

### File Baru:
```
database/migrations/2026_04_06_000001_add_role_to_admins_table.php
app/Http/Middleware/RoleMiddleware.php
resources/views/admin/layouts/app.blade.php
resources/views/admin/history.blade.php
resources/views/admin/kitchen.blade.php (updated)
ROLE_BASED_ACCESS_README.md
update-admin-roles.sql
generate-password-hash.php
```

### File Diubah:
```
app/Models/Admin.php
database/seeders/AdminSeeder.php
bootstrap/app.php
routes/web.php
app/Http/Controllers/OrderController.php
resources/views/admin/dashboard.blade.php
```

---

## 🔒 Middleware Protection

Middleware `role` sudah terdaftar dan melindungi routes:

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

## 🎨 Fitur Tiap Role

### Admin Dashboard Features:
- 📊 Total Pendapatan (semua waktu)
- 🔥 Pesanan Aktif
- 📦 Total Produk (aktif/total)
- 👥 Admin Aktif
- 📈 Grafik penjualan (Hari ini, Minggu ini, Bulan ini)

### Kitchen Features:
- ⏳ Pesanan Menunggu
- 🔥 Pesanan Disiapkan
- ✅ Pesanan Siap Saji
- Update status dengan 1 klik
- Auto-refresh manual

### Orders Management (Admin & Kasir):
- Lihat semua pesanan
- Edit status pesanan
- Hapus pesanan (Admin only)
- Filter berdasarkan status

### History Features (Semua Role):
- 📜 Riwayat pesanan selesai
- ❌ Riwayat pesanan dibatalkan
- 💰 Total pendapatan dari pesanan selesai
- Pagination untuk data besar

---

## ⚠️ Troubleshooting

### Error 403 Unauthorized Access
- User tidak memiliki role yang sesuai
- Cek role user di database tabel `admins`
- Logout dan login ulang

### Menu Tidak Muncul
- Clear cache browser (Ctrl+Shift+Delete)
- Clear Laravel cache: `php artisan cache:clear`
- Clear view cache: `php artisan view:clear`

### Column 'role' not found
- Jalankan SQL script untuk tambah kolom role
- Refresh database connection

### Password tidak cocok
- Generate password hash baru dengan:
  ```bash
  php generate-password-hash.php
  ```
- Update database dengan hash baru

---

## 📊 Database Schema

### Tabel: `admins`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| username | varchar | Unique username |
| email | varchar | Unique email |
| password | varchar | Hashed password |
| name | varchar | Display name |
| **role** | varchar | **admin, kitchen, cashier** |
| is_active | boolean | Account status |
| remember_token | string | Remember me token |
| created_at | timestamp | Created date |
| updated_at | timestamp | Updated date |

---

## 🔐 Security Notes

- Password di-hash menggunakan `bcrypt`
- Middleware melindungi setiap route
- Role di-check di server-side
- Session-based authentication
- CSRF protection aktif

---

## 📞 Support

Jika ada masalah:
1. Cek log: `storage/logs/laravel.log`
2. Cek database: pastikan kolom `role` ada
3. Cek middleware: pastikan terdaftar di `bootstrap/app.php`
4. Cek routes: pastikan middleware terpasang

---

## ✅ Checklist Implementasi

- [x] Migration kolom role
- [x] Model Admin dengan helpers
- [x] Middleware RoleMiddleware
- [x] Routes protection
- [x] AdminSeeder dengan 3 role
- [x] Layout admin dengan menu dinamis
- [x] Dashboard view (admin only)
- [x] Kitchen view (admin & kitchen)
- [x] Orders view (admin & cashier)
- [x] History view (all roles)
- [x] SQL script untuk update database
- [x] Dokumentasi lengkap

---

**© 2026 NgopiGo - Role-Based Access Control System**
