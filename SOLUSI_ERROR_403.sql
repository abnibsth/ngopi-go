-- ============================================
-- SOLUSI CEPAT - Error 403 Unauthorized Access
-- ============================================
-- Copy-paste SEMUA query di bawah ini ke phpMyAdmin
-- ============================================

-- LANGKAH 1: Tambah kolom role ke tabel admins
ALTER TABLE admins ADD COLUMN IF NOT EXISTS role VARCHAR(50) DEFAULT 'admin' AFTER name;

-- LANGKAH 2: Set role 'admin' untuk user admin
UPDATE admins SET role = 'admin' WHERE username = 'admin';

-- LANGKAH 3: Set role 'cashier' untuk user kasir  
UPDATE admins SET role = 'cashier' WHERE username = 'kasir';

-- LANGKAH 4: Tambah user dapur baru (jika belum ada)
INSERT INTO admins (username, email, password, name, role, is_active, created_at, updated_at)
SELECT 'dapur', 'dapur@ngopigo.com', '$2y$10$zY06QG47MnH5ogLQpHhoru6psD/skCPenXXfjSAMdUzEQHGe8v5/u', 'Staff Dapur', 'kitchen', 1, NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM admins WHERE username = 'dapur');

-- LANGKAH 5: Cek hasil
SELECT id, username, name, role FROM admins;

-- SELESAI! Sekarang coba login lagi dengan:
-- Username: admin
-- Password: admin123
