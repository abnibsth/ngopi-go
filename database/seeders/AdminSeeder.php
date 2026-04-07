<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama (opsional - uncomment jika ingin reset)
        // Admin::truncate();

        // Admin - Bisa lihat dashboard, kelola pesanan, dan kelola dapur
        Admin::create([
            'username' => 'admin',
            'email' => 'admin@ngopigo.com',
            'password' => Hash::make('admin123'),
            'name' => 'Administrator',
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Dapur - Bisa kelola dapur dan lihat riwayat pesanan
        Admin::create([
            'username' => 'dapur',
            'email' => 'dapur@ngopigo.com',
            'password' => Hash::make('dapur123'),
            'name' => 'Staff Dapur',
            'role' => 'kitchen',
            'is_active' => true,
        ]);

        // Kasir - Bisa lihat riwayat pesanan dan kelola pesanan
        Admin::create([
            'username' => 'kasir',
            'email' => 'kasir@ngopigo.com',
            'password' => Hash::make('kasir123'),
            'name' => 'Kasir NgopiGo',
            'role' => 'cashier',
            'is_active' => true,
        ]);
    }
}
