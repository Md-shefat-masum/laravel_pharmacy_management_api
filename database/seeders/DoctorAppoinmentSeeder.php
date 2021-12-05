<?php

namespace Database\Seeders;

use App\Models\DoctorAppoinment;
use Illuminate\Database\Seeder;

class DoctorAppoinmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DoctorAppoinment::create([
            'id' => 1,
            'doctor_id' => 3,
            'consumer_id' => 5,
            'date' => '2021-12-05',
            'start_time' => '00:14',
            'end_time' => NULL,
            'appoinment_status' => 'pending',
            'payment_id' => 'RN-61AD0CB030547',
            'transaction_id' => 'ch_3K3PyNElSyBGmOnr0MzqL4MY',
            'payment_status' => 1,
            'creator' => 5,
            'slug' => '61ad0cb0279231',
            'status' => 1,
            'created_at' => '2021-12-05 13:02:08',
            'updated_at' => '2021-12-05 13:02:08'
        ]);

        DoctorAppoinment::create([
            'id' => 2,
            'doctor_id' => 3,
            'consumer_id' => 5,
            'date' => '2021-12-05',
            'start_time' => '01:14',
            'end_time' => NULL,
            'appoinment_status' => 'pending',
            'payment_id' => 'RN-61AD0F22D21D0',
            'transaction_id' => 'ch_3K3Q8UElSyBGmOnr1EwqOCBP',
            'payment_status' => 1,
            'creator' => 5,
            'slug' => '61ad0f22bf39d2',
            'status' => 1,
            'created_at' => '2021-12-05 13:12:34',
            'updated_at' => '2021-12-05 13:12:34'
        ]);
    }
}
