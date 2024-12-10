<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        Product::insert([
            ['name' => 'Ko\'ylak', 'code' => 'KOYLAK001'],
            ['name' => 'Shim', 'code' => 'SHIM002'],
        ]);
    }
}
