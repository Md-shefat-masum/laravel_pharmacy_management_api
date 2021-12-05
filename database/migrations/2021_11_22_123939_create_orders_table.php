<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no',25)->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('pharmacy_id')->nullable();
            $table->double('order_total')->nullable();
            $table->double('shipping_charge')->nullable();
            $table->string('coupon_code',100)->nullable();
            $table->double('coupon_charge')->nullable();
            $table->tinyInteger('payment_status')->default(0);
            $table->string('order_status',50)->default('pending');

            $table->string('creator',20)->nullable();
            $table->string('slug',50)->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
