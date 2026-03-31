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
        Admin::create([
            'username' => 'admin',
            'email' => 'admin@ngopigo.com',
            'password' => Hash::make('admin123'),
            'name' => 'Administrator',
            'is_active' => true,
        ]);

        Admin::create([
            'username' => 'kasir',
            'email' => 'kasir@ngopigo.com',
            'password' => Hash::make('kasir123'),
            'name' => 'Kasir NgopiGo',
            'is_active' => true,
        ]);
    }
}
