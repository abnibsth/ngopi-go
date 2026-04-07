-- ============================================
-- FIX: Error 403 Unauthorized Access - Admin Login
-- ============================================
-- Jalankan di phpMyAdmin/Laragon
-- Database: db_ngopigo
-- ============================================

-- 1. Cek apakah tabel admins ada
SHOW TABLES LIKE 'admins';

-- 2. Cek apakah kolom role sudah ada
-- Jika error "Unknown column", jalankan langkah 3
SELECT role FROM admins LIMIT 1;

-- 3. Tambahkan kolom role jika belum ada
ALTER TABLE admins ADD COLUMN IF NOT EXISTS role VARCHAR(50) DEFAULT 'admin' AFTER name;

-- 4. Update user admin dengan role 'admin'
UPDATE admins SET role = 'admin' WHERE username = 'admin';

-- 5. Update user kasir dengan role 'cashier' (jika ada)
UPDATE admins SET role = 'cashier' WHERE username = 'kasir';

-- 6. Tambahkan user dapur jika belum ada
INSERT IGNORE INTO admins (username, email, password, name, role, is_active, created_at, updated_at)
VALUES ('dapur', 'dapur@ngopigo.com', '$2y$10$zY06QG47MnH5ogLQpHhoru6psD/skCPenXXfjSAMdUzEQHGe8v5/u', 'Staff Dapur', 'kitchen', 1, NOW(), NOW());

-- 7. Verifikasi semua data admin
SELECT id, username, email, name, role, is_active, created_at FROM admins ORDER BY role, username;

-- 8. Cek struktur tabel admins
DESCRIBE admins;
