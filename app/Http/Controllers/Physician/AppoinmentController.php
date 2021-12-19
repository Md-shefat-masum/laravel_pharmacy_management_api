<?php

namespace App\Http\Controllers\Physician;

use App\Http\Controllers\Controller;
use App\Models\DoctorAppoinment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class AppoinmentController extends Controller
{
    public $mode;
    public $merchantId;
    public $merchantPassword;
    public $doctor_id;
    public $customer;

    public function __construct()
    {
        $this->merchantId = "EPM53962246683";
        $this->merchantPassword = '$2y$10$z8c.3HobTEbvw9EwMk6Dz.eGdovmbsPxrtBQCU/dw0squKcnfDz7W';
        $this->mode = "test";
    }

    public function user_appoinments()
    {
        $appoinments = DoctorAppoinment::where('consumer_id', Auth::user()->id)->with([
            'doctor:id,user_name',
            'consumer:id,user_name',
        ])->latest()->paginate(8);
        return response()->json($appoinments, 200);
    }

    public function doctor_appoinments()
    {
        $appoinments = DoctorAppoinment::where('doctor_id', Auth::user()->id)->with([
            'doctor:id,user_name',
            'consumer:id,user_name',
        ])->latest()->paginate(8);
        return response()->json($appoinments, 200);
    }

    public function doctor_approve_appoinments_for_calendar()
    {
        // title: 'Website Re-Design Plan',
        // startDate: new Date(2018, 6, 2, 9, 30),
        // endDate: new Date(2018, 6, 2, 15, 30),
        // id: 16,
        // location: 'Room 1',

        $appoinments = DoctorAppoinment::where('doctor_id', Auth::user()->id)
            ->where('appoinment_status','approved')->get();
        return response()->json($appoinments, 200);
    }

    public function get_user_appoinment($id)
    {
        $appoinment = DoctorAppoinment::where('consumer_id', Auth::user()->id)->where('id', $id)->with([
            // 'doctor:id,user_name,photo',
            'doctor' => function ($query) {
                $query->select(['id', 'user_name', 'photo', 'role_serial', 'dob', 'email', 'contact_number']);
                $query->with(['doctor_assistance:id,doctor_id,name,mobile_number,telephone_number']);
            },
            'consumer:id,dob,user_name',
        ])->first();
        return response()->json($appoinment, 200);
    }

    public function get_doctor_appoinment($id)
    {
        $appoinment = DoctorAppoinment::where('doctor_id', Auth::user()->id)->where('id', $id)->with([
            // 'doctor:id,user_name,photo',
            'doctor' => function ($query) {
                $query->select(['id', 'user_name', 'photo', 'role_serial', 'street', 'city', 'country', 'dob', 'email', 'contact_number']);
                $query->with(['doctor_assistance:id,doctor_id,name,mobile_number,telephone_number']);
            },
            'consumer:id,user_name,photo,dob,role_serial,email,contact_number',
        ])->first();
        return response()->json($appoinment, 200);
    }

    public function doctor_all_appoinments_by_date()
    {
        $date = Carbon::parse(request()->date);
        session()->put('user_appoinment_date', $date);
        $appoinment = DoctorAppoinment::where('doctor_id', Auth::user()->id)->whereDate('date', $date)->with([
            // 'doctor:id,user_name,photo',
            'doctor' => function ($query) {
                $query->select(['id', 'user_name', 'photo', 'role_serial', 'email', 'contact_number']);
                $query->with(['doctor_assistance:id,doctor_id,name,mobile_number,telephone_number']);
            },
            'consumer:id,user_name,photo,role_serial,email,contact_number',
        ])->get()->each(function ($items) {
            return $items->setAppends([
                'total_time',
                'time_diff_from_doctor_start_time',
                'time_range',
                'formatted_start_time',
                'formatted_end_time',
                'time_slot',
            ]);
        });

        return response()->json($appoinment, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => ['required'],
            'date' => ['required'],
            // 'start_time' => ['required'],
            'card_number' => ['required'],
            'month' => ['required'],
            'cvc' => ['required'],
            'payment_amount' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => $validator->errors(),
            ], 422);
        }

        $card_info = [
            'card_number' => $request->card_number,
            'month' => Carbon::parse($request->month)->format('d'),
            'year' => Carbon::parse($request->month)->format('y'),
            'cvc' => $request->cvc,
        ];

        $payemnt = null;
        try {
            $payemnt = $this->payment_bill($request->payment_amount, (object) $card_info);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

        if ((isset($payemnt['status']) &&  $payemnt['status'] == 'failed') || !$payemnt) {
            $err_message = 'transaction failed. Please check card info and try again.';
            // $err = $payemnt['errros']['message'];
            // foreach ($err as $item) {
            //     $err_message .= $item[0].', ';
            // }

            return response()->json([
                'err_message' => 'transaction failed',
                'data' => ['payment_errors' => [$err_message]],
            ], 422);
        }

        $appoinment = new DoctorAppoinment();
        $appoinment->doctor_id = $request->doctor_id;
        $appoinment->consumer_id = Auth::user()->id;
        $appoinment->date = $request->date;
        $appoinment->start_time = $request->start_time;
        $appoinment->payment_id = $payemnt["data"]["rrn"];
        $appoinment->transaction_id = $payemnt["data"]["transactionId"];
        $appoinment->payment_status = 1;
        $appoinment->creator = Auth::user()->id;
        $appoinment->save();
        $appoinment->slug = uniqid() . $appoinment->id;
        $appoinment->save();

        return response()->json($appoinment, 200);
    }

    public function payment_bill($totalAmount, $card_info)
    {
        $response = Http::post('https://epaymaker.com/api/check/purchase', [
            "txnReferenceID" => "txnReferenceID",
            "number" => $card_info->card_number,
            "expirationMonth" => $card_info->month,
            "expirationYear" => $card_info->year,
            "securityCode" => $card_info->cvc,
            "totalAmount" => $totalAmount,
            "currency" => "USD",
            "firstName" => Auth::user()->first_name,
            "lastName" => Auth::user()->last_name,
            "address1" => Auth::user()->street . ', ' . Auth::user()->zip_code . ', ' . Auth::user()->city,
            "locality" => Auth::user()->state,
            "postalCode" => Auth::user()->zip_code,
            "country" => Auth::user()->state,
            "email" => Auth::user()->email,

            "mode" => $this->mode,
            "merchantId" => $this->merchantId,
            "merchantPassword" => $this->merchantPassword,
        ]);

        return $response->json();
    }

    public function set_schedule_for_consumer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => ['required'],
            'end_time' => ['required'],
            'appoinment_link' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => $validator->errors(),
            ], 422);
        }

        $schedule = DoctorAppoinment::find($request->id);

        $check = DoctorAppoinment::where('consumer_id', '!=', $schedule->consumer_id)
            ->where('appoinment_link', $request->appoinment_link)->exists();

        if ($check) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => ["appoinment_link" => ["appoinment_link already taken. regenerate."]],
            ], 422);
        }

        $doctor_schedule_start = Carbon::parse($request->doctor_schedule_start);
        $doctor_schedule_end = Carbon::parse($request->doctor_schedule_end);
        $start_time = Carbon::parse($request->start_time);
        $end_time = Carbon::parse($request->end_time);

        if (!$start_time->between($doctor_schedule_start, $doctor_schedule_end)) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => ["start_time" => ["start time should between {$request->doctor_schedule_start} to {$request->doctor_schedule_end}"]],
            ], 422);
        }

        if (!$end_time->between($doctor_schedule_start, $doctor_schedule_end)) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => ["end_time" => ["end time should between {$request->doctor_schedule_start} to {$request->doctor_schedule_end}"]],
            ], 422);
        }

        if ($start_time->gt($end_time)) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => ["start_time" => ["start time should smaller thant end time."]],
            ], 422);
        }

        $schedules = DoctorAppoinment::where('doctor_id', Auth::user()->id)
            ->where('date', $request->date)->get();

        foreach ($schedules as $item) {
            $check = $start_time->between($item->start_time, $item->end_time);
            if ($check && ($item->consumer_id != $schedule->consumer->id)) {
                return response()->json([
                    'err_message' => 'validation error',
                    'data' => ["start_time" => ["time already been taken."]],
                ], 422);
            }
        }

        foreach ($schedules as $item) {
            $check = $end_time->between($item->start_time, $item->end_time);
            if ($check && ($item->consumer_id != $schedule->consumer->id)) {
                return response()->json([
                    'err_message' => 'validation error',
                    'data' => ["end_time" => ["endtime already been taken."]],
                ], 422);
            }
        }

        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->appoinment_link = $request->appoinment_link;
        $schedule->appoinment_status = 'approved';
        $schedule->save();

        return [
            $schedule,
            $request->all(),
        ];
    }
}
