<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$mapping = [
    'Chocolate Ice' => 'products/chocolate_ice.png',
    'Taro Latte' => 'products/taro_latte.png',
    'Red Velvet' => 'products/red_velvet_latte.png',
    'Lychee Tea' => 'products/lychee_tea.png',
    'Pisang Goreng' => 'products/pisang_goreng.png',
    'Mie Goreng Jawa' => 'products/mie_goreng_jawa.png',
];

foreach ($mapping as $name => $imagePath) {
    \App\Models\Product::where('name', $name)->update(['image' => $imagePath]);
}

echo "Done!\n";
