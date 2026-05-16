<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = \App\Models\Product::all();
foreach($products as $p) {
    $oldPrice = $p->price;
    $newPrice = round($oldPrice * 1.25 / 1000) * 1000;
    if ($newPrice - $oldPrice < 3000) {
        $newPrice = $oldPrice + 3000;
    }
    $p->discount_price = $oldPrice;
    $p->price = $newPrice;
    $p->save();
}
echo "Done updating prices!\n";
