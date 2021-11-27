<?php

namespace Database\Seeders;

use App\Models\Drug;
use App\Models\DrugInformation;
use App\Models\DrugQtyLog;
use Illuminate\Database\Seeder;

class DrugQtyLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 20; $i++) {
            DrugQtyLog::create([
                'pharmacy_id' => 4,
                'drug_id' => rand(1,5),
                'qty' => rand(300,600),
                'creator' => 4,
            ]);
        }

        foreach (Drug::get() as $item) {
            DrugInformation::where('drug_id',$item->id)->update([
                'quantity' => DrugQtyLog::where('drug_id',$item->id)->sum('qty'),
            ]);
        }
    }
}
