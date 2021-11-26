<?php

namespace Database\Seeders;

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
                "start_time" => "10:00",
                "end_time" => "14:00",
            ],
            [
                "day" => "sunday",
                "start_time" => "10:00",
                "end_time" => "14:00",
            ],
            [
                "day" => "monday",
                "start_time" => "10:00",
                "end_time" => "14:00",
            ],
            [
                "day" => "tuesday",
                "start_time" => "10:00",
                "end_time" => "14:00",
            ],
        ];

        $language = ["english","chineese","japaneese","korean"];

        UserDoctorInformaion::create([
            'doctor_id' => 3,
            'speciality' => 'cardiologist',
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
    }
}
