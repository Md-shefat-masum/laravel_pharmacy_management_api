<?php

namespace Database\Seeders;

use App\Models\DoctorAssistance;
use App\Models\DoctorHospital;
use App\Models\DoctorHospitalTime;
use App\Models\UserDoctorInformaion;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserDoctorInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $education = [
            [
                "year" => "2006",
                "degree" => "MBBS,M.D",
                "institute" => "University of Wyoming",
            ],
            [
                "year" => "2007",
                "degree" => "MBBS,M.D",
                "institute" => "Netherland Medical Collage",
            ],
        ];

        $experience = [
            [
                "year" => "2006",
                "department" => "MBBS,M.D",
                "position" => "senior prof",
                "institute" => "University of Wyoming",
                "hospital" => "midtown medical clinic",
            ],
            [
                "year" => "2009",
                "department" => "MBBS,M.D",
                "position" => "Associate prof",
                "institute" => "University of DMC",
                "hospital" => "DMC medical clinic",
            ],
        ];

        $schedule = [
            [
                "day" => "saturday",
                "start_time" => "13:00",
                "end_time" => "17:00",
            ],
            [
                "day" => "sunday",
                "start_time" => "13:00",
                "end_time" => "17:00",
            ],
            [
                "day" => "monday",
                "start_time" => "15:00",
                "end_time" => "18:00",
            ],
            [
                "day" => "tuesday",
                "start_time" => "14:00",
                "end_time" => "17:00",
            ],
            [
                "day" => "wednesday",
                "start_time" => "14:00",
                "end_time" => "17:00",
            ],
            [
                "day" => "thursday",
                "start_time" => "14:00",
                "end_time" => "17:00",
            ],
            [
                "day" => "friday",
                "start_time" => "14:00",
                "end_time" => "17:00",
            ],
        ];

        $language = ["english","chineese","japaneese","korean"];

        UserDoctorInformaion::create([
            'doctor_id' => 3,
            'doctor_charge' => rand(10,30),
            'education' => json_encode($education),
            'experience' => json_encode($experience),
            'schedule' => json_encode($schedule),
            'supported_insurance' => '#ABCSTSC',
            'professor_membership_id' => '#ABCSTSC',
            'licence_no' => '#ABCSTSC',
            'language_spoken' => json_encode($language),
            'prof_membership' => '',
            'created_at' => Carbon::now()->toDateTimeString()
        ]);

        $doctor_hospital = DoctorHospital::create([
            'doctor_id' => 3,
            'hospital' => ['lab aid','mordern','somorita','ibnesina','islamia'][rand(0,4)],
            'street' => ['2286 Sundown Lane','2287 Sundown Lane','2288 Sundown Lane','2289 Sundown Lane','2290 Sundown Lane'][rand(0,4)],
            'city' => ['dhaka','noakhali','new york','goblin','sucide'][rand(0,4)],
            'zip_code' => [rand(1000,9999),rand(1000,9999),rand(1000,9999),rand(1000,9999),rand(1000,9999)][rand(0,4)],
            'country' => 'bangladesh',
            'description' => 'bangladesh institute',
        ]);

        DoctorAssistance::create([
            'doctor_id' => 3,
            'name' => 'assistance 1',
            'description' => 'phramcist',
            'mobile_number' => '+880 '.rand(10000000,99999999),
            'telephone_number' => '12 '.rand(10000000,99999999),
        ]);

        for ($i=0; $i < 5; $i++) {
            DoctorHospitalTime::create([
                'hospital_id' => $doctor_hospital->id,
                'doctor_id' => 3,
                'day' => ['sun','mon','tue','wed','thu'][$i],
                'start_time' => '5:00',
                'end_time' => '10:00',
            ]);
        }

        for ($i=17; $i < 26; $i++) {
            UserDoctorInformaion::create([
                'doctor_id' => $i,
                'doctor_charge' => rand(10,30),
                'education' => json_encode($education),
                'experience' => json_encode($experience),
                'schedule' => json_encode($schedule),
                'supported_insurance' => '#ABCSTSC',
                'professor_membership_id' => '#ABCSTSC',
                'licence_no' => '#ABCSTSC',
                'language_spoken' => json_encode($language),
                'prof_membership' => '',
                'created_at' => Carbon::now()->toDateTimeString()
            ]);

            $doctor_hospital = DoctorHospital::create([
                'doctor_id' => $i,
                'hospital' => ['lab aid','mordern','somorita','ibne sina','islamia'][rand(0,4)],
                'street' => ['2286 Sundown Lane','2287 Sundown Lane','2288 Sundown Lane','2289 Sundown Lane','2290 Sundown Lane'][rand(0,4)],
                'city' => ['dhaka','noakhali','new york','goblin','sucide'][rand(0,4)],
                'zip_code' => [rand(1000,9999),rand(1000,9999),rand(1000,9999),rand(1000,9999),rand(1000,9999)][rand(0,4)],
                'country' => 'bangladesh',
                'description' => 'bangladesh institute',
            ]);

            for ($j=0; $j < 5; $j++) {
                $doctor_hospital_times = DoctorHospitalTime::create([
                    'hospital_id' => $doctor_hospital->id,
                    'doctor_id' => $i,
                    'day' => ['sun','mon','tue','wed','thu'][$j],
                    'start_time' => '5:00',
                    'end_time' => '10:00',
                ]);
            }

            for ($k=0; $k < 2; $k++) {
                DoctorAssistance::create([
                    'doctor_id' => $i,
                    'name' => 'assistance '.($k+1),
                    'description' => 'phramcist',
                    'mobile_number' => '+880 '.rand(10000000,99999999),
                    'telephone_number' => '12 '.rand(10000000,99999999),
                ]);
            }
        }
    }
}
