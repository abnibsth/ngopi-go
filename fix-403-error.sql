-- ============================================
-- FIX: Error 403 Unauthorized Access
-- ============================================
-- Jalankan di phpMyAdmin untuk memperbaiki error 403
-- Database: ngopigo
-- ============================================

-- 1. Cek apakah kolom role sudah ada
-- Jika error "Unknown column", jalankan langkah 2
-- Jika tidak error, lanjut ke langkah 3
SELECT role FROM admins LIMIT 1;

-- 2. Tambahkan kolom role (jika belum ada)
ALTER TABLE admins ADD COLUMN role VARCHAR(50) DEFAULT 'admin' AFTER name;

-- 3. Update semua user admin dengan role 'admin'
UPDATE admins SET role = 'admin' WHERE username = 'admin';

-- 4. Update user kasir dengan role 'cashier'
UPDATE admins SET role = 'cashier' WHERE username = 'kasir';

-- 5. Tambahkan user dapur jika belum ada
INSERT IGNORE INTO admins (username, email, password, name, role, is_active, created_at, updated_at)
VALUES ('dapur', 'dapur@ngopigo.com', '$2y$10$zY06QG47MnH5ogLQpHhoru6psD/skCPenXXfjSAMdUzEQHGe8v5/u', 'Staff Dapur', 'kitchen', 1, NOW(), NOW());

-- 6. Verifikasi data
SELECT id, username, name, role, is_active FROM admins;
