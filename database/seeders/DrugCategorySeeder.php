<?php

namespace Database\Seeders;

use App\Models\DrugCategory;
use Illuminate\Database\Seeder;

class DrugCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DrugCategory::create([
            'pharmacy_id' => 4,
            'name' => 'Antibiotics',
        ]);
        DrugCategory::create([
            'pharmacy_id' => 4,
            'name' => 'Antifungals',
        ]);
        DrugCategory::create([
            'pharmacy_id' => 4,
            'name' => 'Antihistamines',
        ]);
        DrugCategory::create([
            'pharmacy_id' => 4,
            'name' => 'Antipyretics',
        ]);
        DrugCategory::create([
            'pharmacy_id' => 4,
            'name' => 'Corticosteroids',
        ]);
    }
}
