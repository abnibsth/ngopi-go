<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Coffee
            [
                'name' => 'Espresso',
                'description' => 'Kopi espresso murni dengan rasa yang kuat dan kaya',
                'price' => 18000,
                'category' => 'coffee',
                'is_available' => true,
            ],
            [
                'name' => 'Americano',
                'description' => 'Espresso dengan air panas, rasa yang lebih ringan',
                'price' => 20000,
                'category' => 'coffee',
                'is_available' => true,
            ],
            [
                'name' => 'Cappuccino',
                'description' => 'Espresso dengan susu steamed dan foam yang creamy',
                'price' => 25000,
                'category' => 'coffee',
                'is_available' => true,
            ],
            [
                'name' => 'Caffe Latte',
                'description' => 'Espresso dengan susu steamed yang lembut',
                'price' => 26000,
                'category' => 'coffee',
                'is_available' => true,
            ],
            [
                'name' => 'Caramel Macchiato',
                'description' => 'Espresso dengan vanilla syrup, susu, dan caramel drizzle',
                'price' => 30000,
                'category' => 'coffee',
                'is_available' => true,
            ],
            [
                'name' => 'Mocha',
                'description' => 'Espresso dengan coklat dan susu steamed',
                'price' => 28000,
                'category' => 'coffee',
                'is_available' => true,
            ],
            // Non Coffee
            [
                'name' => 'Chocolate Hot/Ice',
                'description' => 'Coklat panas atau dingin yang creamy',
                'price' => 22000,
                'category' => 'non-coffee',
                'is_available' => true,
            ],
            [
                'name' => 'Matcha Latte',
                'description' => 'Matcha Jepang dengan susu steamed',
                'price' => 26000,
                'category' => 'non-coffee',
                'is_available' => true,
            ],
            [
                'name' => 'Taro Latte',
                'description' => 'Taro dengan susu yang creamy dan manis',
                'price' => 24000,
                'category' => 'non-coffee',
                'is_available' => true,
            ],
            [
                'name' => 'Red Velvet',
                'description' => 'Minuman red velvet dengan susu yang unik',
                'price' => 25000,
                'category' => 'non-coffee',
                'is_available' => true,
            ],
            [
                'name' => 'Lychee Tea',
                'description' => 'Teh leci yang segar dan manis',
                'price' => 18000,
                'category' => 'non-coffee',
                'is_available' => true,
            ],
            [
                'name' => 'Lemon Tea',
                'description' => 'Teh lemon yang segar',
                'price' => 16000,
                'category' => 'non-coffee',
                'is_available' => true,
            ],
            // Food
            [
                'name' => 'Nasi Goreng Kampung',
                'description' => 'Nasi goreng tradisional dengan telur dan ayam',
                'price' => 35000,
                'category' => 'food',
                'is_available' => true,
            ],
            [
                'name' => 'Mie Goreng Jawa',
                'description' => 'Mie goreng dengan bumbu jawa yang khas',
                'price' => 32000,
                'category' => 'food',
                'is_available' => true,
            ],
            [
                'name' => 'Ayam Geprek',
                'description' => 'Ayam goreng geprek dengan sambal bawang',
                'price' => 30000,
                'category' => 'food',
                'is_available' => true,
            ],
            [
                'name' => 'Spaghetti Bolognese',
                'description' => 'Spaghetti dengan saus daging bolognese',
                'price' => 38000,
                'category' => 'food',
                'is_available' => true,
            ],
            // Snack
            [
                'name' => 'Kentang Goreng',
                'description' => 'Kentang goreng crispy dengan bumbu',
                'price' => 15000,
                'category' => 'snack',
                'is_available' => true,
            ],
            [
                'name' => 'Roti Bakar',
                'description' => 'Roti bakar dengan berbagai pilihan topping',
                'price' => 18000,
                'category' => 'snack',
                'is_available' => true,
            ],
            [
                'name' => 'Pisang Goreng',
                'description' => 'Pisang goreng crispy dengan madu',
                'price' => 16000,
                'category' => 'snack',
                'is_available' => true,
            ],
            [
                'name' => 'French Fries',
                'description' => 'Kentang goreng crispy ala barat',
                'price' => 18000,
                'category' => 'snack',
                'is_available' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
