<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderBillingAddress;
use App\Models\OrderDetails;
use App\Models\OrderPayment;
use App\Models\OrderPrescription;
use App\Models\OrderPrescriptionImage;
use App\Models\OrderSalesLog;
use App\Models\OrderShippingAddress;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create([
            'id' => 1,
            'order_no' => 'GG202112',
            'customer_id' => 5,
            'pharmacy_id' => 7,
            'order_total' => 168,
            'shipping_charge' => 0,
            'coupon_code' => '',
            'coupon_charge' => 0,
            'payment_status' => 1,
            'order_status' => 'pending',
            'creator' => 5,
            'slug' => uniqid(10),
            'status' => 1,
            'created_at' => '2021-12-04 09:11:49',
            'updated_at' => '2021-12-04 09:11:49'
        ]);

        OrderBillingAddress::create([
            'id' => 1,
            'order_id' => 1,
            'first_name' => 'mr',
            'last_name' => 'consumer',
            'email' => 'consumer@gmail.com',
            'contact_number' => '+9342325327',
            'city' => 'dhaka',
            'zip_code' => '1414',
            'state' => 'bangladesh',
            'street' => 'faruk road 14/A',
            'description' => 'description',
            'created_at' => '2021-12-04 09:11:49',
            'updated_at' => '2021-12-04 09:11:49'
        ]);

        OrderDetails::create([
            'id' => 1,
            'order_id' => '1',
            'pharmacy_id' => 7,
            'product_id' => 2,
            'product_sale_price' => 55,
            'product_sale_tax' => 0,
            'product_unit_price' => 158,
            'qty' => 1,
            'created_at' => '2021-12-04 09:11:49',
            'updated_at' => '2021-12-04 09:11:49'
        ]);

        OrderDetails::create([
            'id' => 2,
            'order_id' => '1',
            'pharmacy_id' => 7,
            'product_id' => 3,
            'product_sale_price' => 61,
            'product_sale_tax' => 0,
            'product_unit_price' => 68,
            'qty' => 1,
            'created_at' => '2021-12-04 09:11:49',
            'updated_at' => '2021-12-04 09:11:49'
        ]);

        OrderDetails::create([
            'id' => 3,
            'order_id' => '1',
            'pharmacy_id' => 7,
            'product_id' => 4,
            'product_sale_price' => 52,
            'product_sale_tax' => 0,
            'product_unit_price' => 68,
            'qty' => 1,
            'created_at' => '2021-12-04 09:11:49',
            'updated_at' => '2021-12-04 09:11:49'
        ]);

        OrderPayment::create([
            'id' => 1,
            'order_id' => '1',
            'user_id' => 5,
            'pharmacy_id' => 7,
            'payment_id' => uniqid(10),
            'transaction_id' => uniqid(10),
            'payment_amount' => '294',
            'created_at' => '2021-12-04 09:11:49',
            'updated_at' => '2021-12-04 09:11:49'
        ]);

        OrderPrescriptionImage::create([
            'id' => 1,
            'order_id' => 1,
            'pharmacy_id' => 7,
            'image' => 'uploads/seed/prescription.jpg',
            'created_at' => '2021-12-04 09:11:49',
            'updated_at' => '2021-12-04 09:11:49'
        ]);

        OrderShippingAddress::create([
            'id' => 1,
            'order_id' => 1,
            'first_name' => 'mr',
            'last_name' => 'consumer',
            'email' => 'consumer@gmail.com',
            'contact_number' => '+9342325327',
            'city' => 'dhaka',
            'zip_code' => '1414',
            'state' => 'bangladesh',
            'street' => 'faruk road 14/A',
            'description' => 'description',
            'created_at' => '2021-12-04 09:11:49',
            'updated_at' => '2021-12-04 09:11:49'
        ]);

        Ordersaleslog::create([
            'id' => 1,
            'order_id' => '2',
            'product_id' => 2,
            'qty' => 1,
            'action_type' => 'customer_order',
            'created_at' => '2021-12-04 09:23:53',
            'updated_at' => '2021-12-04 09:23:53'
        ]);

        Ordersaleslog::create([
            'id' => 2,
            'order_id' => '2',
            'product_id' => 3,
            'qty' => 1,
            'action_type' => 'customer_order',
            'created_at' => '2021-12-04 09:23:53',
            'updated_at' => '2021-12-04 09:23:53'
        ]);

        OrderSalesLog::create([
            'id' => 3,
            'order_id' => '2',
            'product_id' => 4,
            'qty' => 1,
            'action_type' => 'customer_order',
            'created_at' => '2021-12-04 09:23:53',
            'updated_at' => '2021-12-04 09:23:53'
        ]);

        OrderPrescription::create([
            'id' => 1,
            'user_id' => 5,
            'pharmacy_id' => 7,
            'image' => 'uploads/seed/prescription.jpg',
            'order_status' => 'pending',
            'created_at' => '2021-12-05 06:19:37',
            'updated_at' => '2021-12-05 06:19:37'
        ]);
    }
}
