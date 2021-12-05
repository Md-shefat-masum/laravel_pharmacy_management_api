<?php

namespace Database\Seeders;

use App\Models\DoctorSpeciality;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DoctorSpeciality::create(['title'=>'Medicine Specialist']);
        DoctorSpeciality::create(['title'=>'Aesthetic Dermatologist']);
        DoctorSpeciality::create(['title'=>'Eye Diseases']);
        DoctorSpeciality::create(['title'=>'Child Diseases']);
        DoctorSpeciality::create(['title'=>'Orthopedic Specialist']);
        DoctorSpeciality::create(['title'=>'Skin']);
        DoctorSpeciality::create(['title'=>'Allergy']);
        DoctorSpeciality::create(['title'=>'Leprosy ']);

        DB::table('doctor_speciality_user')->insert(['doctor_speciality_id'=>1,'user_id'=>3,'created_at'=>Carbon::now()->toDateTimeString()]);
        DB::table('doctor_speciality_user')->insert(['doctor_speciality_id'=>2,'user_id'=>3,'created_at'=>Carbon::now()->toDateTimeString()]);
        DB::table('doctor_speciality_user')->insert(['doctor_speciality_id'=>3,'user_id'=>3,'created_at'=>Carbon::now()->toDateTimeString()]);
        DB::table('doctor_speciality_user')->insert(['doctor_speciality_id'=>4,'user_id'=>3,'created_at'=>Carbon::now()->toDateTimeString()]);

        for ($i=17; $i < 26; $i++) {
            for ($j=1; $j < rand(3,7); $j++) {
                DB::table('doctor_speciality_user')->insert(['doctor_speciality_id'=>$j,'user_id'=>$i,'created_at'=>Carbon::now()->toDateTimeString()]);
            }
        }
    }
}
