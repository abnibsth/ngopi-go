# 🔧 SOLUSI: Error 403 Saat Login Admin

## 📋 Masalah
Ketika login ke admin, muncul error **403 Unauthorized Access** dengan pesan:
> "Unauthorized access. You do not have permission to access this page."

## 🎯 Penyebab
1. **User admin tidak memiliki role yang benar** di database
2. **Kolom `role` belum ada** di tabel `admins`
3. Setelah login, sistem mengarahkan ke dashboard yang hanya bisa diakses role `admin`

## ✅ Solusi

### Langkah 1: Jalankan Script SQL Fix

1. Buka **phpMyAdmin** di Laragon: http://localhost/phpmyadmin
2. Pilih database: **`db_ngopigo`**
3. Klik tab **SQL**
4. Copy-paste script berikut:

```sql
-- Tambahkan kolom role jika belum ada
ALTER TABLE admins ADD COLUMN IF NOT EXISTS role VARCHAR(50) DEFAULT 'admin' AFTER name;

-- Set role 'admin' untuk user admin
UPDATE admins SET role = 'admin' WHERE username = 'admin';

-- Set role 'cashier' untuk user kasir (jika ada)
UPDATE admins SET role = 'cashier' WHERE username = 'kasir';

-- Tambahkan user dapur jika belum ada
INSERT IGNORE INTO admins (username, email, password, name, role, is_active, created_at, updated_at)
VALUES ('dapur', 'dapur@ngopigo.com', '$2y$10$zY06QG47MnH5ogLQpHhoru6psD/skCPenXXfjSAMdUzEQHGe8v5/u', 'Staff Dapur', 'kitchen', 1, NOW(), NOW());

-- Verifikasi
SELECT id, username, email, name, role, is_active FROM admins;
```

5. Klik **Go** atau **Kirim**
6. Pastikan tidak ada error

### Langkah 2: Clear Cache (Opsional)

Jika masih error, clear cache Laravel:

```bash
cd c:\laragon\www\ngopi-go
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

### Langkah 3: Test Login

1. Buka: http://127.0.0.1:8000/admin/login
2. Login dengan kredensial berikut:

| Role | Username | Password | Akses |
|------|----------|----------|-------|
| **Admin** | `admin` | `admin123` | ✅ Semua Menu |
| **Dapur** | `dapur` | `dapur123` | ✅ Kitchen & History |
| **Kasir** | `kasir` | `kasir123` | ✅ Orders & History |

3. Setelah login berhasil, Anda akan diarahkan ke halaman yang sesuai dengan role Anda

## 🔍 Verifikasi

### Cek di Database

Jalankan query ini di phpMyAdmin untuk memastikan role sudah benar:

```sql
SELECT id, username, name, role, is_active FROM admins WHERE username = 'admin';
```

Harusnya menampilkan:
```
id | username | name        | role  | is_active
---|----------|-------------|-------|----------
1  | admin    | Administrator | admin | 1
```

### Cek File yang Sudah Diperbaiki

File `app/Http/Controllers/Admin/AuthController.php` sudah diperbaiki dengan redirect otomatis berdasarkan role:
- **Admin** → Dashboard Admin
- **Kasir** → Halaman Orders
- **Dapur** → Kitchen View
- **Lainnya** → History

## ⚠️ Troubleshooting

### Masih Error 403?

1. **Pastikan user admin ada:**
   ```sql
   SELECT * FROM admins WHERE username = 'admin';
   ```

2. **Pastikan kolom role ada:**
   ```sql
   DESCRIBE admins;
   ```
   Harus ada kolom `role` dengan type `varchar(50)`

3. **Reset password admin:**
   ```sql
   UPDATE admins 
   SET password = '$2y$10$x0AJmxjYA1OgnNQDIJIKjO5CCToYro.ClBTGEaoCDxCjiCn7Wj7SK',
       role = 'admin',
       is_active = 1
   WHERE username = 'admin';
   ```

### Error "Column 'role' not found"

Jalankan perintah ini:

```sql
ALTER TABLE admins ADD COLUMN role VARCHAR(50) DEFAULT 'admin' AFTER name;
```

### Error "Table 'admins' doesn't exist"

Buat tabel admins terlebih dahulu:

```sql
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(50) DEFAULT 'admin',
    is_active BOOLEAN DEFAULT TRUE,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## 📞 Butuh Bantuan?

Jika masih ada masalah:
1. Cek log file di `storage/logs/laravel.log`
2. Pastikan database `db_ngopigo` sudah dibuat
3. Pastikan middleware sudah terdaftar di `bootstrap/app.php`
