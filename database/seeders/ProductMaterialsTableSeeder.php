<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductMaterial;

class ProductMaterialsTableSeeder extends Seeder
{
    public function run()
    {
        ProductMaterial::insert([
            ['product_id' => 1, 'material_id' => 1, 'quantity' => 0.8], // Mato
            ['product_id' => 1, 'material_id' => 2, 'quantity' => 5],  // Tugma
            ['product_id' => 1, 'material_id' => 3, 'quantity' => 10], // Ip

            ['product_id' => 2, 'material_id' => 1, 'quantity' => 1.4], // Mato
            ['product_id' => 2, 'material_id' => 3, 'quantity' => 15],  // Ip
            ['product_id' => 2, 'material_id' => 4, 'quantity' => 1],   // Zamok
        ]);
    }
}
