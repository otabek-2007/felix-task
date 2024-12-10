<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialsTableSeeder extends Seeder
{
    public function run()
    {
        Material::insert([
            ['name' => 'Mato'],
            ['name' => 'Tugma'],
            ['name' => 'Ip'],
            ['name' => 'Zamok'],
        ]);
    }
}
