-- Script SQL untuk update gambar produk
-- Jalankan di MySQL/phpMyAdmin
-- Pastikan sudah menjalankan: php artisan storage:link
-- Atau membuat symbolic link manual: mklink /J public\storage storage\app\public

-- Update path gambar dengan path yang benar untuk storage link
UPDATE products SET image = 'products/espresso.jpg' WHERE name = 'Espresso';
UPDATE products SET image = 'products/americano.jpg' WHERE name = 'Americano';
UPDATE products SET image = 'products/cappuccino.jpg' WHERE name = 'Cappuccino';
UPDATE products SET image = 'products/caffe-latte.jpg' WHERE name = 'Caffe Latte';
UPDATE products SET image = 'products/caramel-macchiato.jpg' WHERE name = 'Caramel Macchiato';
UPDATE products SET image = 'products/mocha.jpg' WHERE name = 'Mocha';
UPDATE products SET image = 'products/chocolate.jpg' WHERE name = 'Chocolate Hot/Ice';
UPDATE products SET image = 'products/matcha-latte.jpg' WHERE name = 'Matcha Latte';
UPDATE products SET image = 'products/taro-latte.jpg' WHERE name = 'Taro Latte';
UPDATE products SET image = 'products/red-velvet.jpg' WHERE name = 'Red Velvet';
UPDATE products SET image = 'products/lychee-tea.jpg' WHERE name = 'Lychee Tea';
UPDATE products SET image = 'products/lemon-tea.jpg' WHERE name = 'Lemon Tea';
UPDATE products SET image = 'products/nasi-goreng.jpg' WHERE name = 'Nasi Goreng Kampung';
UPDATE products SET image = 'products/mie-goreng.jpg' WHERE name = 'Mie Goreng Jawa';
UPDATE products SET image = 'products/ayam-geprek.jpg' WHERE name = 'Ayam Geprek';
UPDATE products SET image = 'products/spaghetti-bolognese.jpg' WHERE name = 'Spaghetti Bolognese';
UPDATE products SET image = 'products/kentang-goreng.jpg' WHERE name = 'Kentang Goreng';
UPDATE products SET image = 'products/roti-bakar.jpg' WHERE name = 'Roti Bakar';
UPDATE products SET image = 'products/pisang-goreng.jpg' WHERE name = 'Pisang Goreng';
UPDATE products SET image = 'products/french-fries.jpg' WHERE name = 'French Fries';
