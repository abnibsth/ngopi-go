<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$mapping = [
    'Cappuccino latte art' => 'products/cappuccino.png',
    'Caffe Latte' => 'products/cappuccino.png',
    'Mocha' => 'products/cappuccino.png',
    
    'Nasi Goreng Kampung' => 'products/nasi_goreng.png',
    'Mie Goreng Jawa' => 'products/nasi_goreng.png',
    
    'Matcha Latte' => 'products/iced_matcha.png',
    'Taro Latte' => 'products/iced_matcha.png',
    'Red Velvet' => 'products/iced_matcha.png',
    'Chocolate Ice' => 'products/iced_matcha.png',
    
    'Roti Bakar' => 'products/roti_bakar.png',
    'Pisang Goreng' => 'products/roti_bakar.png',
    
    'Spaghetti Bolognese' => 'products/spaghetti.png',
    'Ayam Geprek' => 'products/ayam_geprek.png',
    'Kentang Goreng' => 'products/kentang_goreng.png',
    
    'Lemon Tea' => 'products/iced_lemon_tea.png',
    'Lychee Tea' => 'products/iced_lemon_tea.png',
    
    'Espresso' => 'products/hot_americano.png',
    'Americano' => 'products/hot_americano.png',
];

foreach ($mapping as $name => $imagePath) {
    \App\Models\Product::where('name', $name)->update(['image' => $imagePath]);
}

echo "Done updating all images!\n";
