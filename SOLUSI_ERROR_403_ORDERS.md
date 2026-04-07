# 🔧 SOLUSI: Error 403 di /admin/orders/44

## 📋 Masalah
Ketika mengakses `/admin/orders/44` (edit pesanan), muncul error **403 Unauthorized Access**.

## 🎯 Penyebab
User yang login memiliki role **`kitchen` (dapur)**, sedangkan route edit pesanan hanya bisa diakses oleh role **`admin`** dan **`cashier`**.

## ✅ Solusi yang Sudah Diterapkan

### 1. Update Routes - Beri Akses Dapur ke Orders ✅

File `routes/web.php` sudah diperbaiki:

**Sebelum:**
```php
Route::get('/orders/{id}/edit', ...)->middleware(['admin', 'role:admin,cashier']);
Route::put('/orders/{id}', ...)->middleware(['admin', 'role:admin,cashier']);
```

**Sesudah:**
```php
Route::get('/orders/{id}/edit', ...)->middleware(['admin', 'role:admin,cashier,kitchen']);
Route::put('/orders/{id}', ...)->middleware(['admin', 'role:admin,cashier,kitchen']);
```

Sekarang user **`dapur`** juga bisa:
- ✅ Lihat daftar pesanan
- ✅ Edit status pesanan
- ✅ Update pesanan

### 2. Database Sudah Benar ✅

Data admin di database:

| Username | Role | Akses |
|----------|------|-------|
| `admin` | admin | ✅ Semua Menu |
| `kasir` | cashier | ✅ Orders & History |
| `dapur` | kitchen | ✅ Kitchen, Orders, & History |

---

## 🧪 Test Sekarang

### Login sebagai Dapur:
1. URL: http://127.0.0.1:8000/admin/login
2. Username: **`dapur`**
3. Password: **`dapur123`**
4. Sekarang bisa akses: **Kitchen View**, **Orders**, dan **History**

### Login sebagai Admin:
1. URL: http://127.0.0.1:8000/admin/login
2. Username: **`admin`**
3. Password: **`admin123`**
4. Akses: **Semua Menu**

### Login sebagai Kasir:
1. URL: http://127.0.0.1:8000/admin/login
2. Username: **`kasir`**
3. Password: **`kasir123`**
4. Akses: **Orders** dan **History**

---

## 🔒 Hak Akses Tiap Role (Updated)

### 👑 ADMIN
- ✅ Dashboard Admin
- ✅ Kelola Pesanan (Create, Read, Update, Delete)
- ✅ Kelola Produk
- ✅ Kitchen View
- ✅ Riwayat Pesanan

### 🍳 DAPUR (Kitchen)
- ❌ Dashboard Admin
- ✅ Kelola Pesanan (Read, Update) - **BARU!**
- ❌ Kelola Produk
- ✅ Kitchen View
- ✅ Riwayat Pesanan

### 💵 KASIR (Cashier)
- ❌ Dashboard Admin
- ✅ Kelola Pesanan (Read, Update)
- ❌ Kelola Produk
- ❌ Kitchen View
- ✅ Riwayat Pesanan

---

## 📝 Catatan Penting

### ⚠️ Jika Masih Error 403

1. **Clear browser cache** (Ctrl + Shift + Delete)
2. **Logout dan login ulang**
3. **Verifikasi role user** di database:

```sql
SELECT username, role, is_active FROM admins;
```

### 🔍 Debug Mode

Jika masih ada masalah, cek log Laravel di:
```
c:\laragon\www\ngopi-go\storage\logs\laravel.log
```

Akan ada log seperti:
```
[timestamp] local.INFO: Role Check {"username":"dapur","role":"kitchen","required_roles":["admin","cashier","kitchen"]}
```

---

## 📞 Butuh Bantuan?

Jika masih error:
1. Screenshot error lengkap dengan URL
2. User yang login (username)
3. Cek log file
