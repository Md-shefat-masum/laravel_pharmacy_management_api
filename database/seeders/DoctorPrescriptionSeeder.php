<?php

namespace Database\Seeders;

use App\Models\DoctorAppoinment;
use App\Models\DoctorPrescription;
use App\Models\DoctorPrescriptionInvestigation;
use App\Models\DoctorPrescriptionMedicine;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DoctorPrescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prescription = new DoctorPrescription();
        $prescription->appoinment_id = 5;
        $prescription->doctor_id = 3;
        $prescription->consumer_id = 5;
        $prescription->additional_message = "<p>revisit after 2 months.</p>";
        $prescription->save();
        $prescription->slug = Carbon::now()->year . $prescription->id;
        $prescription->save();

        $prescribeMedicine = '[
            {
                "name": "Flexi",
                "description": "half of a tablate",
                "days": "30",
                "morning": true,
                "afternoon": false,
                "evening": false,
                "night": true,
                "before_eat": false,
                "after_eat": false,
                "empty_stomach": true
            },
            {
                "name": "Tylace",
                "description": "2 table spoon",
                "days": "15",
                "morning": true,
                "afternoon": true,
                "evening": false,
                "night": true,
                "before_eat": false,
                "after_eat": true,
                "empty_stomach": false
            }
        ]';

        $invetigations = ' [
            {
                "name": "ECG",
                "description": "from Popular hospital"
            },
            {
                "name": "Blood Test",
                "description": "from labaid hospital"
            }
        ]';

        foreach (json_decode($prescribeMedicine) as $item) {
            $item = (object) $item;
            $doctor_prescription_medicines = new DoctorPrescriptionMedicine();
            $doctor_prescription_medicines->prescription_id = $prescription->id;
            $doctor_prescription_medicines->name = $item->name;
            $doctor_prescription_medicines->days = $item->days;
            $doctor_prescription_medicines->description = $item->description;
            $doctor_prescription_medicines->morning = $item->morning;
            $doctor_prescription_medicines->afternoon = $item->afternoon;
            $doctor_prescription_medicines->evening = $item->evening;
            $doctor_prescription_medicines->night = $item->night;
            $doctor_prescription_medicines->before_eat = $item->before_eat;
            $doctor_prescription_medicines->after_eat = $item->after_eat;
            $doctor_prescription_medicines->empty_stomach = $item->empty_stomach;
            $doctor_prescription_medicines->save();
            $doctor_prescription_medicines->slug = Carbon::now()->year . $doctor_prescription_medicines->id;
            $doctor_prescription_medicines->save();
        }

        foreach (json_decode($invetigations) as $item) {
            $item = (object) $item;
            $doctor_prescription_investigations = new DoctorPrescriptionInvestigation();
            $doctor_prescription_investigations->prescription_id = $prescription->id;
            $doctor_prescription_investigations->name = $item->name;
            $doctor_prescription_investigations->description = $item->description;
            $doctor_prescription_investigations->save();

            $doctor_prescription_investigations->slug = Carbon::now()->year . $doctor_prescription_investigations->id;
            $doctor_prescription_investigations->save();
        }
    }
}
