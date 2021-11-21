<?php

namespace Database\Seeders;

use App\Models\DrugManufacturer;
use Illuminate\Database\Seeder;

class DrugManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DrugManufacturer::insert([
            'pharmacy_id' => 4,
            'name' => 'COSMIC PHARMA LIMITED',
        ]);
        DrugManufacturer::insert([
            'pharmacy_id' => 4,
            'name' => 'Drug International Limited',
        ]);
        DrugManufacturer::insert([
            'pharmacy_id' => 4,
            'name' => 'Gaco Pharmaceuticals',
        ]);
        DrugManufacturer::insert([
            'pharmacy_id' => 4,
            'name' => 'General Pharma',
        ]);
        DrugManufacturer::insert([
            'pharmacy_id' => 4,
            'name' => 'GlaxoSmithKline',
        ]);
        DrugManufacturer::insert([
            'pharmacy_id' => 4,
            'name' => 'Globe Pharmaceuticals Ltd.',
        ]);
        DrugManufacturer::insert([
            'pharmacy_id' => 4,
            'name' => 'Naafco Pharma Ltd.',
        ]);
        DrugManufacturer::insert([
            'pharmacy_id' => 4,
            'name' => 'Navana Pharmaceuticals Ltd.',
        ]);
    }
}
