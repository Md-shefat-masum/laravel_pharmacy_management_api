<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSalesLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_sales_logs', function (Blueprint $table) {
            $table->id();
            $table->string('order_id',100)->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('qty')->nullable();
            $table->string('action_type',100)->nullable();
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
        Schema::dropIfExists('order_sales_logs');
    }
}
