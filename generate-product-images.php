<?php

// Script untuk membuat gambar placeholder untuk produk
// Jalankan dengan: php generate-product-images.php

$products = [
    // Coffee
    'espresso.jpg',
    'americano.jpg',
    'cappuccino.jpg',
    'caffe-latte.jpg',
    'caramel-macchiato.jpg',
    'mocha.jpg',
    // Non Coffee
    'chocolate.jpg',
    'matcha-latte.jpg',
    'taro-latte.jpg',
    'red-velvet.jpg',
    'lychee-tea.jpg',
    'lemon-tea.jpg',
    // Food
    'nasi-goreng.jpg',
    'mie-goreng.jpg',
    'ayam-geprek.jpg',
    'spaghetti-bolognese.jpg',
    // Snack
    'kentang-goreng.jpg',
    'roti-bakar.jpg',
    'pisang-goreng.jpg',
    'french-fries.jpg',
];

$colors = [
    'coffee' => ['#4B3832', '#6F4E37', '#854442'],
    'non-coffee' => ['#D4A574', '#A8D8EA', '#F4A6B2'],
    'food' => ['#FF6B6B', '#FFE66D', '#FF8C42'],
    'snack' => ['#FFD93D', '#FF6B6B', '#FF8C42'],
];

$labels = [
    'espresso.jpg' => 'Espresso',
    'americano.jpg' => 'Americano',
    'cappuccino.jpg' => 'Cappuccino',
    'caffe-latte.jpg' => 'Caffe Latte',
    'caramel-macchiato.jpg' => 'Caramel Macchiato',
    'mocha.jpg' => 'Mocha',
    'chocolate.jpg' => 'Chocolate',
    'matcha-latte.jpg' => 'Matcha Latte',
    'taro-latte.jpg' => 'Taro Latte',
    'red-velvet.jpg' => 'Red Velvet',
    'lychee-tea.jpg' => 'Lychee Tea',
    'lemon-tea.jpg' => 'Lemon Tea',
    'nasi-goreng.jpg' => 'Nasi Goreng',
    'mie-goreng.jpg' => 'Mie Goreng',
    'ayam-geprek.jpg' => 'Ayam Geprek',
    'spaghetti-bolognese.jpg' => 'Spaghetti',
    'kentang-goreng.jpg' => 'Kentang Goreng',
    'roti-bakar.jpg' => 'Roti Bakar',
    'pisang-goreng.jpg' => 'Pisang Goreng',
    'french-fries.jpg' => 'French Fries',
];

$categories = [
    'espresso.jpg' => 'coffee',
    'americano.jpg' => 'coffee',
    'cappuccino.jpg' => 'coffee',
    'caffe-latte.jpg' => 'coffee',
    'caramel-macchiato.jpg' => 'coffee',
    'mocha.jpg' => 'coffee',
    'chocolate.jpg' => 'non-coffee',
    'matcha-latte.jpg' => 'non-coffee',
    'taro-latte.jpg' => 'non-coffee',
    'red-velvet.jpg' => 'non-coffee',
    'lychee-tea.jpg' => 'non-coffee',
    'lemon-tea.jpg' => 'non-coffee',
    'nasi-goreng.jpg' => 'food',
    'mie-goreng.jpg' => 'food',
    'ayam-geprek.jpg' => 'food',
    'spaghetti-bolognese.jpg' => 'food',
    'kentang-goreng.jpg' => 'snack',
    'roti-bakar.jpg' => 'snack',
    'pisang-goreng.jpg' => 'snack',
    'french-fries.jpg' => 'snack',
];

$outputDir = __DIR__ . '/public/images/products';

if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
    echo "Folder dibuat: $outputDir\n";
}

foreach ($products as $filename) {
    $category = $categories[$filename];
    $label = $labels[$filename];
    $colorList = $colors[$category];
    $bgColor = $colorList[array_rand($colorList)];
    
    $width = 400;
    $height = 300;
    
    // Buat gambar placeholder dengan GD
    $img = imagecreatetruecolor($width, $height);
    
    // Parse warna hex
    $r = hexdec(substr($bgColor, 1, 2));
    $g = hexdec(substr($bgColor, 3, 2));
    $b = hexdec(substr($bgColor, 5, 2));
    
    $bg = imagecolorallocate($img, $r, $g, $b);
    
    // Warna teks (putih atau hitam tergantung kecerahan background)
    $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
    $textColor = $brightness > 128 
        ? imagecolorallocate($img, 50, 50, 50) 
        : imagecolorallocate($img, 255, 255, 255);
    
    // Fill background
    imagefilledrectangle($img, 0, 0, $width, $height, $bg);
    
    // Tambahkan teks nama produk
    $fontSize = 5; // Built-in font size (1-5)
    $fontWidth = imagefontwidth($fontSize);
    $fontHeight = imagefontheight($fontSize);
    
    $textWidth = $fontWidth * strlen($label);
    $textHeight = $fontHeight;
    
    $x = ($width - $textWidth) / 2;
    $y = ($height - $textHeight) / 2;
    
    imagestring($img, $fontSize, $x, $y, $label, $textColor);
    
    // Tambahkan label kategori
    $categoryLabel = strtoupper($category);
    $categoryWidth = $fontWidth * strlen($categoryLabel);
    $categoryX = ($width - $categoryWidth) / 2;
    
    imagestring($img, 3, $categoryX, $y + 20, $categoryLabel, $textColor);
    
    // Simpan gambar
    $filepath = $outputDir . '/' . $filename;
    imagejpeg($img, $filepath, 85);
    imagedestroy($img);
    
    echo "✓ Dibuat: $filename\n";
}

echo "\nSelesai! Semua gambar produk telah dibuat di folder public/images/products/\n";
