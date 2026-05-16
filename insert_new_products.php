<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\App\Models\Product::create([
    'name' => 'Kopi Susu Gula Aren',
    'description' => 'Signature iced coffee dengan gula aren asli nusantara dan fresh milk.',
    'price' => 30000,
    'discount_price' => 25000,
    'category' => 'coffee',
    'image' => 'products/kopi_susu_gula_aren.png',
    'is_available' => true,
]);

\App\Models\Product::create([
    'name' => 'Rice Bowl Chicken Teriyaki',
    'description' => 'Nasi pulen Jepang dengan ayam teriyaki, wijen sangrai, dan telur mata sapi.',
    'price' => 45000,
    'discount_price' => 38000,
    'category' => 'food',
    'image' => 'products/rice_bowl.png',
    'is_available' => true,
]);

\App\Models\Product::create([
    'name' => 'Mix Platter',
    'description' => 'Keranjang cemilan sharing berisi kentang goreng, sosis, dan chicken nugget.',
    'price' => 40000,
    'discount_price' => 32000,
    'category' => 'snack',
    'image' => 'products/mix_platter.png',
    'is_available' => true,
]);

echo "Done adding new products!\n";
