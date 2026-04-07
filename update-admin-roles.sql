-- ============================================
-- Script SQL untuk Update Role-Based Access
-- ============================================
-- Jalankan di MySQL/phpMyAdmin
-- Database: ngopigo
-- ============================================

-- 1. Tambahkan kolom role ke tabel admins (jika belum ada)
ALTER TABLE admins ADD COLUMN IF NOT EXISTS role VARCHAR(50) DEFAULT 'admin' AFTER name;

-- 2. Update admin yang sudah ada dengan role yang sesuai
UPDATE admins SET role = 'admin' WHERE username = 'admin';
UPDATE admins SET role = 'cashier' WHERE username = 'kasir';

-- 3. Tambahkan user baru untuk Dapur (jika belum ada)
INSERT INTO admins (username, email, password, name, role, is_active, created_at, updated_at)
SELECT 'dapur', 'dapur@ngopigo.com', '$2y$10$zY06QG47MnH5ogLQpHhoru6psD/skCPenXXfjSAMdUzEQHGe8v5/u', 'Staff Dapur', 'kitchen', 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM admins WHERE username = 'dapur');

-- 4. Update password untuk semua user (gunakan hash yang baru di-generate)
UPDATE admins SET password = '$2y$10$x0AJmxjYA1OgnNQDIJIKjO5CCToYro.ClBTGEaoCDxCjiCn7Wj7SK' WHERE username = 'admin';
UPDATE admins SET password = '$2y$10$7IYadYx70isaZ.DQMbR2QuDlqFtfsAKPzUiM9/jf/glhGLQ.Jy29a' WHERE username = 'dapur';
UPDATE admins SET password = '$2y$10$ag1uzJLT73wNGxsiFKd3Yew.vI.xj7YsqQ.6hOwAt1urZUG1Wmrg.' WHERE username = 'kasir';

-- 5. Verifikasi data
SELECT id, username, email, name, role, is_active, created_at FROM admins ORDER BY role, username;


