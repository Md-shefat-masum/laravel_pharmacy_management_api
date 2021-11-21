<?php

namespace Database\Seeders;

use App\Models\DrugInformation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DrugInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DrugInformation::insert([
            'drug_id' => 1,
            'manufacturing_date' => '2018-01-14',
            'expiry_date' => '2034-01-14',
            'quantity' => 2000,
            'date_of_entry' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
