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
        DrugCategory::insert([
            'pharmacy_id' => 4,
            'name' => 'Antibiotics',
        ]);
        DrugCategory::insert([
            'pharmacy_id' => 4,
            'name' => 'Antifungals',
        ]);
        DrugCategory::insert([
            'pharmacy_id' => 4,
            'name' => 'Antihistamines',
        ]);
        DrugCategory::insert([
            'pharmacy_id' => 4,
            'name' => 'Antipyretics',
        ]);
        DrugCategory::insert([
            'pharmacy_id' => 4,
            'name' => 'Corticosteroids',
        ]);
    }
}
