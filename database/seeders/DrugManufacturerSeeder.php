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
        DrugManufacturer::create([
            'pharmacy_id' => 4,
            'name' => 'COSMIC PHARMA LIMITED',
        ]);
        DrugManufacturer::create([
            'pharmacy_id' => 4,
            'name' => 'Drug International Limited',
        ]);
        DrugManufacturer::create([
            'pharmacy_id' => 4,
            'name' => 'Gaco Pharmaceuticals',
        ]);
        DrugManufacturer::create([
            'pharmacy_id' => 4,
            'name' => 'General Pharma',
        ]);
        DrugManufacturer::create([
            'pharmacy_id' => 4,
            'name' => 'GlaxoSmithKline',
        ]);
        DrugManufacturer::create([
            'pharmacy_id' => 4,
            'name' => 'Globe Pharmaceuticals Ltd.',
        ]);
        DrugManufacturer::create([
            'pharmacy_id' => 4,
            'name' => 'Naafco Pharma Ltd.',
        ]);
        DrugManufacturer::create([
            'pharmacy_id' => 4,
            'name' => 'Navana Pharmaceuticals Ltd.',
        ]);
    }
}
