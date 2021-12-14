<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderBillingAddress;
use App\Models\OrderDetails;
use App\Models\OrderPayment;
use App\Models\OrderPrescription;
use App\Models\OrderPrescriptionImage;
use App\Models\OrderSalesLog;
use App\Models\OrderShippingAddress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public $mode;
    public $merchantId;
    public $merchantPassword;
    public $pharmacy_id;
    public $customer_id;

    public function __construct()
    {
        $this->merchantId = env("EPAY_MERCHANT_ID");
        $this->merchantPassword = env("EPAY_MERCHANT_PASSWORD");
        $this->mode = env("EPAY_PAYMENT_MODE");

        // $this->merchantId = "EPM53962246683";
        // $this->merchantPassword = '$2y$10$z8c.3HobTEbvw9EwMk6Dz.eGdovmbsPxrtBQCU/dw0squKcnfDz7W';
        // $this->mode = "test";
    }

    public function customer_orders()
    {
        $query = Order::where('customer_id', Auth::user()->id)->orderBy('id', 'DESC');
        if (request()->has('payment_status') && request()->payment_status == 0) {
            $query->where('payment_status', 0);
        }
        $orders = $query->paginate(8);
        return response()->json($orders, 200);
    }

    public function details($id)
    {
        $order = Order::where('id', $id)->where('status', 1)->with([
            'shipping_address',
            'billing_address',
            'order_details' => function ($query) {
                $query->with(['drug_details:id,name']);
            },
            'payment_details:id,order_id,payment_id,transaction_id,payment_amount',
            'order_image'
        ])->first();
        return $order;
    }

    public function saveorder(Request $request)
    {
        $data = [];
        $data2 = [];
        foreach ($request->except('files') as $key => $item) {
            $data[$key] = collect(json_decode($item))->toArray();
            $data2[$key] = (object) json_decode($item);
        }
        $data2 = (object) $data2;

        // return $data['seletedPharmacy'];
        $validator = Validator::make($data, [
            'seletedPharmacy.user_name' => ['required'],
            'seletedPharmacy.street' => ['required'],
            'seletedPharmacy.contact_number' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'err_description' => "please select a pharmacy.",
                'err_for' => 'select_pharmacy',
                'data' => $validator->errors(),
            ], 422);
        }

        if ($request->ShippingForm) {
            $validator = Validator::make($data, [
                'billingAddress.billing_first_name' => ['required'],
                'billingAddress.billing_last_name' => ['required'],
                'billingAddress.billing_email' => ['required'],
                'billingAddress.billing_contact_number' => ['required'],
                'billingAddress.billing_city' => ['required'],
                'billingAddress.billing_zip_code' => ['required'],
                'billingAddress.billing_state' => ['required'],
                'billingAddress.billing_street' => ['required'],
                // 'billingAddress.billing_description' => ['required'],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'err_message' => 'validation error',
                    'err_for' => 'billing',
                    'err_description' => "please fillup all billing address informations.",
                    'data' => $validator->errors(),
                ], 422);
            }

            $validator = Validator::make($data, [
                'shippingAddress.billing_first_name' => ['required'],
                'shippingAddress.billing_last_name' => ['required'],
                'shippingAddress.billing_email' => ['required'],
                'shippingAddress.billing_contact_number' => ['required'],
                'shippingAddress.billing_city' => ['required'],
                'shippingAddress.billing_zip_code' => ['required'],
                'shippingAddress.billing_state' => ['required'],
                'shippingAddress.billing_street' => ['required'],
                // 'shippingAddress.billing_description' => ['required'],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'err_message' => 'validation error',
                    'err_for' => 'shipping',
                    'err_description' => 'please fillup all shipping address informations.',
                    'data' => $validator->errors(),
                    // 'data' => ['shipping_address'=>"please fillup all shipping address informations."],
                ], 422);
            }
        }

        $validator = Validator::make($data, [
            'paymentInfo.card_number' => ['required'],
            'paymentInfo.cvc' => ['required'],
            'paymentInfo.month' => ['required'],
            'paymentInfo.year' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'err_for' => 'payment',
                'err_description' => 'please fillup all payment informations.',
                'data' => $validator->errors(),
            ], 422);
        }

        // return $data2->seletedPharmacy->id;

        // set pharmacy and customer id
        $this->pharmacy_id = $data2->seletedPharmacy->id;
        $this->customer_id = Auth::user()->id;

        // store order
        $order = $this->store_order($this->pharmacy_id, $this->customer_id, $request->total);

        // store order products
        $this->order_products($order, $data2->selectedMedicine);

        // store billing info
        $this->store_billing_info($data2->billingAddress, $order->id);

        // store shipping info
        $this->store_shipping_info($data2->shippingAddress, $order->id);

        // store prescription images
        $this->store_prescription_images($order->id, $this->pharmacy_id, $request);

        // store payment info
        $this->store_payment_info($request->total, $order, $this->pharmacy_id, $data2->paymentInfo, $data2->billingAddress);

        return $order;
    }

    public function store_order($pharmacy_id, $customer_id, $total, $shipping_charge = 0, $coupone_code = '', $coupone_charge = 0, $payment_status = 0)
    {
        $order = new Order();
        $order->order_no = 'GG' . Carbon::now()->year . Carbon::now()->month;
        $order->customer_id = $customer_id;
        $order->pharmacy_id = $pharmacy_id;
        $order->order_total = $total;
        $order->shipping_charge = $shipping_charge;
        $order->coupon_code = $coupone_code;
        $order->coupon_charge = $coupone_charge;
        $order->payment_status = $payment_status;
        $order->order_status = 'pending';
        $order->save();
        $order->creator = Auth::user()->id;
        $order->slug = $order->id . uniqid(10);
        $order->order_no = 'GG' . Carbon::now()->year . Carbon::now()->month . $order->id;
        $order->save();

        return $order;
    }

    public function order_products($order, $products)
    {
        foreach ($products as $item) {
            $order_details = new OrderDetails();
            $order_details->order_id = $order->id;
            $order_details->pharmacy_id = $order->pharmacy_id;
            $order_details->product_id = $item->id;
            $order_details->product_sale_price = $item->sales_price;
            $order_details->product_sale_tax = 0;
            $order_details->product_unit_price = $item->unit_price;
            $order_details->qty = $item->qty;
            $order_details->save();

            $order_sales_log = new OrderSalesLog();
            $order_sales_log->order_id = $order->id;
            $order_sales_log->product_id = $order_details->product_id;
            $order_sales_log->qty = $order_details->qty;
            $order_sales_log->action_type = 'customer_order';
            $order_sales_log->save();
        }
    }

    public function store_payment_info($payment_amount, $order, $pharmacy_id, $card_info, $billing_address)
    {
        $payment_info = $this->payment_bill($payment_amount, $card_info, $billing_address);

        // echo "<pre>" . var_dump($payment_info) . "</pre>";
        if (isset($payment_info['data'])) {


            if (isset($payment_info['data']['transactionId'])) {
                $order->payment_status = 1;
                $order->save();
            }

            $transaction_id = $payment_info['data']['transactionId'];
            $payment_id = $payment_info['data']['rrn'];
            $order_payments = new OrderPayment();
            $order_payments->order_id = $order->id;
            $order_payments->user_id = Auth::user()->id;
            $order_payments->pharmacy_id = $pharmacy_id;
            $order_payments->payment_id = $payment_id;
            $order_payments->transaction_id = $transaction_id;
            $order_payments->payment_amount = $payment_amount;
            $order_payments->save();
        }
    }

    public function store_billing_info($data, $order_id)
    {
        $order_billing_address = new OrderBillingAddress();
        $order_billing_address->order_id = $order_id;
        $order_billing_address->first_name = $data->billing_first_name;
        $order_billing_address->last_name = $data->billing_last_name;
        $order_billing_address->email = $data->billing_email;
        $order_billing_address->contact_number = $data->billing_contact_number;
        $order_billing_address->city = $data->billing_city;
        $order_billing_address->state = $data->billing_state;
        $order_billing_address->street = $data->billing_street;
        $order_billing_address->zip_code = $data->billing_zip_code;
        $order_billing_address->description = isset($data->billing_description) ? $data->billing_description : '';
        $order_billing_address->save();
    }

    public function store_shipping_info($data, $order_id)
    {
        $order_shipping_address = new OrderShippingAddress();
        $order_shipping_address->order_id = $order_id;
        $order_shipping_address->first_name = $data->billing_first_name;
        $order_shipping_address->last_name = $data->billing_last_name;
        $order_shipping_address->email = $data->billing_email;
        $order_shipping_address->contact_number = $data->billing_contact_number;
        $order_shipping_address->city = $data->billing_city;
        $order_shipping_address->state = $data->billing_state;
        $order_shipping_address->street = $data->billing_street;
        $order_shipping_address->zip_code = $data->billing_zip_code;
        $order_shipping_address->description = isset($data->billing_description) ? $data->billing_description : '';
        $order_shipping_address->save();
    }

    public function store_prescription_images($order_id, $pharmacy_id, $request)
    {
        for ($i = 0; $i < $request->files_count; $i++) {
            if ($request->hasFile('files' . $i)) {
                $path = Storage::put('uploads/test', $request->file('files' . $i));
                $order_prescription_images = new OrderPrescriptionImage();
                $order_prescription_images->order_id = $order_id;
                $order_prescription_images->pharmacy_id = $pharmacy_id;
                $order_prescription_images->image = $path;
                $order_prescription_images->save();
            }
        }
    }

    public function payment_bill($totalAmount, $card_info, $billing_address)
    {
        $response = Http::post('https://epaymaker.com/api/check/purchase', [
            "txnReferenceID" => "txnReferenceID",
            "number" => $card_info->card_number,
            "expirationMonth" => $card_info->month,
            "expirationYear" => $card_info->year,
            "securityCode" => $card_info->cvc,
            "totalAmount" => $totalAmount,
            "currency" => "USD",
            "firstName" => $billing_address->billing_first_name,
            "lastName" => $billing_address->billing_last_name,
            "address1" => $billing_address->billing_street . ', ' . $billing_address->billing_zip_code . ', ' . $billing_address->billing_city,
            "locality" => $billing_address->billing_state,
            "postalCode" => $billing_address->billing_zip_code,
            "country" => $billing_address->billing_state,
            "email" => $billing_address->billing_email,

            "mode" => $this->mode,
            "merchantId" => $this->merchantId,
            "merchantPassword" => $this->merchantPassword,
            // "merchantId" => "EPM53962246683",
            // "merchantPassword" => '$2y$10$z8c.3HobTEbvw9EwMk6Dz.eGdovmbsPxrtBQCU/dw0squKcnfDz7W',
        ]);

        return $response->json();
    }

    public function create_prescription_order(Request $request)
    {
        // return $data['seletedPharmacy'];
        $validator = Validator::make($request->all(), [
            'files' => ['required', 'min:3'],
            'pharmacy_id' => ['required'],
        ], [
            'pharmacy_id.required' => 'no pharmacy was selected',
            'pharmacy_id.min' => 'no pharmacy was selected',
            'files.required' => 'no prescription was selected',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => $validator->errors(),
            ], 422);
        }

        $order_prescirption = new OrderPrescription();
        $order_prescirption->user_id = Auth::user()->id;
        $order_prescirption->pharmacy_id = $request->pharmacy_id;
        $order_prescirption->save();
        if ($request->hasFile('files')) {
            $path = Storage::put('uploads/order_prescription', $request->file('files'));
            $order_prescirption->image = $path;
        }
        $order_prescirption->save();
        return $order_prescirption;
    }

    public function test(Request $request)
    {
        if ($request->hasFile('image')) {
            Storage::put('uploads/test', $request->file('image'));
            return 'get';
        }
    }

    public function customer_order_payment(Request $request)
    {
        $card_info = OrderBillingAddress::where('order_id', $request->order_id)->first();
        $order = Order::where('customer_id', Auth::user()->id)->where('id', $request->order_id)->first();
        $response = Http::post('https://epaymaker.com/api/check/purchase', [
            "txnReferenceID" => "txnReferenceID",
            "number" => $request->card_number,
            "expirationMonth" => $request->month,
            "expirationYear" => $request->year,
            "securityCode" => $request->cvc,
            "totalAmount" => $order->order_total,
            "currency" => "USD",
            "firstName" => $card_info->first_name,
            "lastName" => $card_info->last_name,
            "address1" => $card_info->street . ', ' . $card_info->zip_code . ', ' . $card_info->city,
            "locality" => $card_info->state,
            "postalCode" => $card_info->zip_code,
            "country" => $card_info->state,
            "email" => $card_info->email,

            "mode" => $this->mode,
            "merchantId" => $this->merchantId,
            "merchantPassword" => $this->merchantPassword,
        ]);

        if($response->ok()){
            $order->payment_status = 1;
            $order->save();

            $transaction_id = $response->json()['data']['transactionId'];
            $payment_id = $response->json()['data']['rrn'];
            $order_payments = new OrderPayment();
            $order_payments->order_id = $order->id;
            $order_payments->user_id = Auth::user()->id;
            $order_payments->pharmacy_id = $order->pharmacy_id;
            $order_payments->payment_id = $payment_id;
            $order_payments->transaction_id = $transaction_id;
            $order_payments->payment_amount = $order->order_total;
            $order_payments->save();

            return response()->json('success',200);
        }else{
            if($response->status() == 422){
                return response()->json('fill the required area',400);
            }
            if($response->status() == 500){
                return response()->json('payment failed. check card information and try again',400);
            }
        }

        // return [
        //     $response->body(),
        //     $response->json(),
        //     $response->object(),
        //     $response->collect(),

        //     $response->status(),
        //     $response->ok(),
        //     $response->successful(),

        //     $response->failed(),
        //     $response->serverError(),
        //     $response->clientError(),
        //     $response->headers(),
        // ];

    }
}
