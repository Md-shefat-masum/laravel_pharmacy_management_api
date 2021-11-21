<?php

namespace Database\Seeders;

use App\Models\DrugStorage;
use Illuminate\Database\Seeder;

class DrugStorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DrugStorage::insert([
            'pharmacy_id' => 4,
            'name' => 'Switch building',
        ]);
        DrugStorage::insert([
            'pharmacy_id' => 4,
            'name' => 'North road 3rd floor',
        ]);
        DrugStorage::insert([
            'pharmacy_id' => 4,
            'name' => 'East corneer 2nd room',
        ]);
        DrugStorage::insert([
            'pharmacy_id' => 4,
            'name' => 'West corneer 1st room',
        ]);
        DrugStorage::insert([
            'pharmacy_id' => 4,
            'name' => 'South corneer 1st room',
        ]);
    }
}
