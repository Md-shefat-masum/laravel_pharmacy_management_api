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
        for ($i = 1; $i <= 5; $i++) {
            DrugInformation::create([
                'drug_id' => $i,
                'manufacturing_date' => '2018-01-14',
                'expiry_date' => '2024-01-14',
                'indication' => 'ZanthinTM is indicated as strong antioxidant. This product is also indicated for beautification and skin improvement, healthy immune system, cardiovascular health, to treat chronic inflammation & healthy brain function.',
                'preparation' => 'ZanthinTM 2 Licap: Each pack contains 30 capsules in blister pack ZanthinTM 4 Licap: Each pack contains 20 capsules in blister pack',
                'dosage_and_administration' => '
                    <p>The recommended daily dosage is fairly standardized at a 4 mg per day. Following is a table of recommended dosages:</p>
                    <table border="1" cellspacing="0" cellpadding="0" width="637">
                        <tbody>
                            <tr>
                                <td width="103" valign="top"><p align="center"><strong>Dosage</strong></p></td>
                                <td width="534" valign="top"><p align="center"><strong>Use</strong></p></td>
                            </tr>
                            <tr>
                                <td width="103" valign="top"><p>2-4 mg</p></td>
                                <td width="534" valign="top"><p>Antioxidant, Cardiovascular Health, Immune System Enhancer </p> </td>
                            </tr>
                            <tr>
                                <td width="103" valign="top"><p>4-8 mg</p></td>
                                <td width="534" valign="top"><p>Internal Beauty and Skin Improvement, Strength and endurance, Brain and Central Nervous System Health, Eye Health </p></td>
                            </tr>
                            <tr>
                                <td width="103" valign="top"><p>4-12 mg</p></td>
                                <td width="534" valign="top"><p>Arthritis, Silent inflammation (C-reactive protein), Internal Sunscreen </p></td>
                            </tr>
                        </tbody>
                    </table>
                ',
                'quantity' => 0,
                'date_of_entry' => Carbon::now()->toDateString(),
            ]);
        }
    }
}
