# 🔧 SOLUSI: Tidak Bisa Login User Dapur

## ✅ Masalah Sudah Diperbaiki!

### 📋 Yang Sudah Dilakukan:

1. **✅ Update Password Hash** - Semua password sudah di-generate ulang dengan PHP `password_hash()`
2. **✅ Update Routes** - User dapur bisa akses `/admin/orders`
3. **✅ Verifikasi Database** - Semua user aktif dan punya role yang benar

---

## 🔑 Kredensial Login (UPDATED)

Gunakan kredensial berikut untuk login:

| Role | Username | Password | URL Redirect |
|------|----------|----------|--------------|
| **Admin** | `admin` | `admin123` | `/admin/dashboard` |
| **Dapur** | `dapur` | `dapur123` | `/admin/kitchen` |
| **Kasir** | `kasir` | `kasir123` | `/admin/orders` |

---

## 🧪 Test Login User Dapur

### Langkah 1: Login
1. Buka: **http://127.0.0.1:8000/admin/login**
2. Username: **`dapur`**
3. Password: **`dapur123`**
4. Klik **Login**

### Langkah 2: Verifikasi Redirect
Setelah login, seharusnya diarahkan ke: **http://127.0.0.1:8000/admin/kitchen**

### Langkah 3: Test Akses Orders
1. Klik menu **Pesanan** atau langsung akses: **http://127.0.0.1:8000/admin/orders**
2. Seharusnya **bisa akses** tanpa error 403

---

## 🔍 Jika Masih Tidak Bisa Login

### 1. Clear Browser Cache
- Tekan **Ctrl + Shift + Delete**
- Clear **Cookies** dan **Cache**
- Atau coba **Incognito Mode** (Ctrl + Shift + N)

### 2. Logout dan Login Ulang
Jika masih login dengan user lain:
1. Klik **Logout**
2. Clear session browser
3. Login ulang dengan kredensial dapur

### 3. Verifikasi Database
Jalankan query ini di phpMyAdmin:

```sql
SELECT id, username, name, role, is_active, 
       CASE WHEN is_active = 1 THEN '✅ Aktif' ELSE '❌ Nonaktif' END as status
FROM admins 
WHERE username = 'dapur';
```

Harusnya menampilkan:
```
id | username | name        | role    | is_active | status
---|----------|-------------|---------|-----------|--------
3  | dapur    | Staff Dapur | kitchen |         1 | ✅ Aktif
```

### 4. Reset Password Manual
Jika masih error, reset password dapur:

```sql
UPDATE admins 
SET password = '$2y$10$69NOajdjWU/efPwaNJoAsu/3Ff2uklzLBtm5gBKUr7TwZ649Zr.M2' 
WHERE username = 'dapur';
```

---

## 📊 Hak Akses User Dapur (Kitchen)

| Menu | Akses | URL |
|------|-------|-----|
| Dashboard Admin | ❌ | `/admin/dashboard` |
| Kitchen View | ✅ | `/admin/kitchen` |
| Kelola Pesanan | ✅ | `/admin/orders` |
| Edit Pesanan | ✅ | `/admin/orders/{id}/edit` |
| Update Pesanan | ✅ | `/admin/orders/{id}` (PUT) |
| Hapus Pesanan | ❌ | `/admin/orders/{id}` (DELETE) |
| Riwayat Pesanan | ✅ | `/admin/history` |
| Kelola Produk | ❌ | `/admin/products` |

---

## 🎯 Redirect Setelah Login

Sistem sekarang otomatis redirect berdasarkan role:

- **Admin** → `/admin/dashboard`
- **Dapur** → `/admin/kitchen`
- **Kasir** → `/admin/orders`
- **Role lain** → `/admin/history`

---

## 📞 Masih Ada Masalah?

1. **Screenshot error** lengkap dengan URL
2. **Cek log Laravel**: `storage/logs/laravel.log`
3. **Verifikasi user login**: Username yang digunakan

### Debug: Cek Log Laravel
Akses log di: `c:\laragon\www\ngopi-go\storage\logs\laravel.log`

Cari baris seperti:
```
[timestamp] local.INFO: Role Check {"username":"dapur","role":"kitchen",...}
```

---

## ✅ Verifikasi Sukses Login

Setelah login berhasil, Anda akan melihat:
- ✅ Menu **Kitchen View** (untuk dapur)
- ✅ Menu **Pesanan** (untuk dapur)
- ✅ Menu **Riwayat** (untuk semua role)
- ✅ Tombol **Logout** di pojok kanan atas

Selamat! 🎉
