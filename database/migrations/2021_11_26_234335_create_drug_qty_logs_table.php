<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugQtyLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_qty_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pharmacy_id')->nullable();
            $table->bigInteger('drug_id')->nullable();
            $table->bigInteger('qty')->nullable();
            $table->string('creator',20)->nullable();
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
        Schema::dropIfExists('drug_qty_logs');
    }
}
