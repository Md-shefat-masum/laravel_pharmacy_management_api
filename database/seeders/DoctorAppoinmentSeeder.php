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
            'start_time' => '13:00',
            'end_time' => '13:30',
            'appoinment_link' => NULL,
            'appoinment_status' => 'pending',
            'payment_id' => 'RN-61AD0CB030547',
            'transaction_id' => 'ch_3K3PyNElSyBGmOnr0MzqL4MY',
            'payment_status' => 1,
            'creator' => 5,
            'slug' => '61ad0cb0279231',
            'status' => 1,
            'created_at' => '2021-12-05 07:02:08',
            'updated_at' => '2021-12-05 07:02:08'
        ]);

        DoctorAppoinment::create([
            'id' => 2,
            'doctor_id' => 3,
            'consumer_id' => 5,
            'date' => '2021-12-05',
            'start_time' => '13:31',
            'end_time' => '14:00',
            'appoinment_link' => NULL,
            'appoinment_status' => 'pending',
            'payment_id' => 'RN-61AD0F22D21D0',
            'transaction_id' => 'ch_3K3Q8UElSyBGmOnr1EwqOCBP',
            'payment_status' => 1,
            'creator' => 5,
            'slug' => '61ad0f22bf39d2',
            'status' => 1,
            'created_at' => '2021-12-05 07:12:34',
            'updated_at' => '2021-12-05 07:12:34'
        ]);

        DoctorAppoinment::create([
            'id' => 3,
            'doctor_id' => 3,
            'consumer_id' => 5,
            'date' => '2021-12-05',
            'start_time' => '14:15',
            'end_time' => '14:45',
            'appoinment_link' => NULL,
            'appoinment_status' => 'pending',
            'payment_id' => 'RN-61B7806C1CF58',
            'transaction_id' => 'ch_3K6IAZElSyBGmOnr1ic8WHBa',
            'payment_status' => 1,
            'creator' => 5,
            'slug' => '61b7806be30bd3',
            'status' => 1,
            'created_at' => '2021-12-13 11:18:35',
            'updated_at' => '2021-12-13 11:18:35'
        ]);

        DoctorAppoinment::create([
            'id' => 4,
            'doctor_id' => 3,
            'consumer_id' => 5,
            'date' => '2021-12-05',
            'start_time' => '15:20',
            'end_time' => '15:50',
            'appoinment_link' => NULL,
            'appoinment_status' => 'pending',
            'payment_id' => 'RN-61B78136142BE',
            'transaction_id' => 'ch_3K6IDpElSyBGmOnr14WsQX2h',
            'payment_status' => 1,
            'creator' => 5,
            'slug' => '61b78135cdb9f4',
            'status' => 1,
            'created_at' => '2021-12-13 11:21:57',
            'updated_at' => '2021-12-13 11:21:57'
        ]);
    }
}
