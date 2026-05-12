<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@toko.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@toko.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $elektronik = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik', 'description' => 'Produk elektronik']);
        $pakaian = Category::create(['name' => 'Pakaian', 'slug' => 'pakaian', 'description' => 'Produk pakaian']);
        $makanan = Category::create(['name' => 'Makanan & Minuman', 'slug' => 'makanan-minuman', 'description' => 'Produk makanan dan minuman']);

        Product::create(['category_id' => $elektronik->id, 'name' => 'Smartphone XYZ', 'slug' => 'smartphone-xyz', 'price' => 3500000, 'stock' => 10]);
        Product::create(['category_id' => $elektronik->id, 'name' => 'Laptop ABC', 'slug' => 'laptop-abc', 'price' => 8500000, 'stock' => 5]);
        Product::create(['category_id' => $elektronik->id, 'name' => 'Headphone Wireless', 'slug' => 'headphone-wireless', 'price' => 450000, 'stock' => 20]);
        Product::create(['category_id' => $pakaian->id, 'name' => 'Kaos Polos', 'slug' => 'kaos-polos', 'price' => 75000, 'stock' => 50]);
        Product::create(['category_id' => $pakaian->id, 'name' => 'Jaket Hoodie', 'slug' => 'jaket-hoodie', 'price' => 150000, 'stock' => 30]);
        Product::create(['category_id' => $makanan->id, 'name' => 'Kopi Arabika 250gr', 'slug' => 'kopi-arabika-250gr', 'price' => 45000, 'stock' => 100]);
        Product::create(['category_id' => $makanan->id, 'name' => 'Snack Mix Pack', 'slug' => 'snack-mix-pack', 'price' => 25000, 'stock' => 200]);
    }
}
