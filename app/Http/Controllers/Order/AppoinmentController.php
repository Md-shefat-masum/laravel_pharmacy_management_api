<?php

namespace App\Http\Controllers\Order;

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
        $appoinments = DoctorAppoinment::where('consumer_id',Auth::user()->id)->with([
            'doctor:id,user_name',
            'consumer:id,user_name',
        ])->latest()->paginate(8);
        return response()->json($appoinments,200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => ['required'],
            'date' => ['required'],
            'start_time' => ['required'],
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
            $err_message = 'transaction failed';
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
}
