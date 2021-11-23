<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->string('order_id',100)->nullable();
            $table->bigInteger('pharmacy_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->double('product_sale_price')->nullable();
            $table->double('product_sale_tax')->nullable();
            $table->double('product_unit_price')->nullable();
            $table->bigInteger('qty')->nullable();
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
        Schema::dropIfExists('order_details');
    }
}
