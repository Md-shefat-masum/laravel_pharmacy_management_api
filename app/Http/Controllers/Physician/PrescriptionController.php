<?php

namespace App\Http\Controllers\Physician;

use App\Http\Controllers\Controller;
use App\Models\DoctorPrescription;
use App\Models\DoctorPrescriptionInvestigation;
use App\Models\DoctorPrescriptionMedicine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function get_doctor_prescriptions()
    {
        $prescriptions = DoctorPrescription::where("doctor_id", Auth::user()->id)
            ->where('status', 1)
            ->with('consumer:id,first_name,last_name,user_name')
            ->latest()->paginate(8);
        return response()->json($prescriptions, 200);
    }

    public function get_doctor_prescription($id)
    {
        $prescription = DoctorPrescription::where("doctor_id", Auth::user()->id)
            ->where('id', $id)
            ->where('status', 1)
            ->with(
                [
                    'doctor' => function ($query) {
                        $query->select(['id', 'user_name','street','city','country', 'photo', 'role_serial', 'dob', 'email', 'contact_number']);
                        $query->with(['doctor_assistance:id,doctor_id,name,mobile_number,telephone_number']);
                    },
                    'consumer:id,dob,user_name,gender',
                    'investigations',
                    'medicines',
                ]
            )
            ->latest()->first();
        return response()->json($prescription, 200);
    }

    public function store(Request $request)
    {
        if (
            (is_array($request->prescribeMedicine) && count($request->prescribeMedicine) == 0) &&
            (is_array($request->invetigations) && count($request->invetigations) == 0)
        ) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => ["prescribeMedicine" => ["no medicine or inventigation present."]],
            ], 422);
        }

        $prescription = new DoctorPrescription();
        $prescription->appoinment_id = $request['appoinment']['id'];
        $prescription->doctor_id = $request['appoinment']['doctor_id'];
        $prescription->consumer_id = $request['appoinment']['consumer_id'];
        $prescription->additional_message = $request->description;
        $prescription->save();
        $prescription->slug = Carbon::now()->year . $prescription->id;
        $prescription->save();

        if (is_array($request->prescribeMedicine) && count($request->prescribeMedicine) > 0) {
            foreach ($request->prescribeMedicine as $item) {
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
        }

        if (is_array($request->invetigations) && count($request->invetigations) > 0) {
            foreach ($request->invetigations as $item) {
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

        return [
            $request->all(),
        ];
    }

    public function update(Request $request)
    {
        if (
            (is_array($request->prescribeMedicine) && count($request->prescribeMedicine) == 0) &&
            (is_array($request->invetigations) && count($request->invetigations) == 0)
        ) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => ["prescribeMedicine" => ["no medicine or inventigation present."]],
            ], 422);
        }

        $prescription = DoctorPrescription::where('id',$request->prescription_id)->first();
        $prescription->appoinment_id = $request['appoinment']['id'];
        $prescription->doctor_id = $request['appoinment']['doctor_id'];
        $prescription->consumer_id = $request['appoinment']['consumer_id'];
        $prescription->additional_message = $request->description;
        $prescription->save();
        $prescription->slug = Carbon::now()->year . $prescription->id;
        $prescription->save();

        if (is_array($request->prescribeMedicine) && count($request->prescribeMedicine) > 0) {
            DoctorPrescriptionMedicine::where('prescription_id',$request->prescription_id)->delete();
            foreach ($request->prescribeMedicine as $item) {
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
        }

        if (is_array($request->invetigations) && count($request->invetigations) > 0) {
            DoctorPrescriptionInvestigation::where('prescription_id',$request->prescription_id)->delete();
            foreach ($request->invetigations as $item) {
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

        return [
            $request->all(),
        ];
    }
}
