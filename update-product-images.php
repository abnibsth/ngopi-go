<?php
// Script untuk update gambar produk langsung ke database
// Pastikan konfigurasi database sudah benar di .env

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbHost = $_ENV['DB_HOST'] ?? 'localhost';
$dbPort = $_ENV['DB_PORT'] ?? '3306';
$dbName = $_ENV['DB_DATABASE'] ?? 'ngopigo';
$dbUser = $_ENV['DB_USERNAME'] ?? 'root';
$dbPass = $_ENV['DB_PASSWORD'] ?? '';

try {
    $pdo = new PDO(
        "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8mb4",
        $dbUser,
        $dbPass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $productImages = [
        'Espresso' => 'products/espresso.jpg',
        'Americano' => 'products/americano.jpg',
        'Cappuccino' => 'products/cappuccino.jpg',
        'Caffe Latte' => 'products/caffe-latte.jpg',
        'Caramel Macchiato' => 'products/caramel-macchiato.jpg',
        'Mocha' => 'products/mocha.jpg',
        'Chocolate Hot/Ice' => 'products/chocolate.jpg',
        'Matcha Latte' => 'products/matcha-latte.jpg',
        'Taro Latte' => 'products/taro-latte.jpg',
        'Red Velvet' => 'products/red-velvet.jpg',
        'Lychee Tea' => 'products/lychee-tea.jpg',
        'Lemon Tea' => 'products/lemon-tea.jpg',
        'Nasi Goreng Kampung' => 'products/nasi-goreng.jpg',
        'Mie Goreng Jawa' => 'products/mie-goreng.jpg',
        'Ayam Geprek' => 'products/ayam-geprek.jpg',
        'Spaghetti Bolognese' => 'products/spaghetti-bolognese.jpg',
        'Kentang Goreng' => 'products/kentang-goreng.jpg',
        'Roti Bakar' => 'products/roti-bakar.jpg',
        'Pisang Goreng' => 'products/pisang-goreng.jpg',
        'French Fries' => 'products/french-fries.jpg',
    ];

    $stmt = $pdo->prepare("UPDATE products SET image = :image WHERE name = :name");
    
    foreach ($productImages as $name => $image) {
        $stmt->execute([
            'image' => $image,
            'name' => $name
        ]);
        echo "✓ Updated: $name -> $image\n";
    }

    echo "\nSelesai! Semua gambar produk telah diupdate di database.\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Pastikan konfigurasi database di .env sudah benar.\n";
}
