-- ============================================
-- FIX FINAL: Error 403 Admin Login
-- ============================================
-- PENTING: Jalankan SEMUA query di bawah ini
-- Database: db_ngopigo
-- ============================================

-- 1. Pastikan kolom role ada (jika error, skip langkah ini)
ALTER TABLE admins ADD COLUMN IF NOT EXISTS role VARCHAR(50) DEFAULT 'admin' AFTER name;

-- 2. SETELAH kolom ada, update SEMUA user dengan role yang benar
UPDATE admins SET role = 'admin' WHERE username = 'admin';
UPDATE admins SET role = 'cashier' WHERE username = 'kasir';

-- 3. Tambah user dapur jika belum ada (dengan role yang benar)
INSERT IGNORE INTO admins (username, email, password, name, role, is_active, created_at, updated_at)
VALUES (
    'dapur', 
    'dapur@ngopigo.com', 
    '$2y$10$zY06QG47MnH5ogLQpHhoru6psD/skCPenXXfjSAMdUzEQHGe8v5/u', 
    'Staff Dapur', 
    'kitchen', 
    1, 
    NOW(), 
    NOW()
);

-- 4. PENTING: Pastikan user admin punya role 'admin' (force update)
UPDATE admins 
SET role = 'admin', 
    is_active = 1 
WHERE username = 'admin';

-- 5. VERIFIKASI: Cek semua user dan role-nya
SELECT 
    id, 
    username, 
    name, 
    role, 
    is_active,
    CASE 
        WHEN role IS NULL OR role = '' THEN '❌ ROLE KOSONG!'
        ELSE '✅ OK'
    END as status
FROM admins 
ORDER BY username;

-- 6. Cek struktur tabel
DESCRIBE admins;
