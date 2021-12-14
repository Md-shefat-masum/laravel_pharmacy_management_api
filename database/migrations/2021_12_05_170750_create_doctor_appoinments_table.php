<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorAppoinmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_appoinments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('doctor_id')->nullable();
            $table->bigInteger('consumer_id')->nullable();
            $table->string('date',10)->nullable();
            $table->string('start_time',10)->nullable();
            $table->string('end_time',10)->nullable();
            $table->text('appoinment_link')->nullable();
            $table->string('appoinment_status',20)->default('pending');

            $table->string('payment_id',100)->nullable();
            $table->string('transaction_id',100)->nullable();
            $table->tinyInteger('payment_status')->default(0);

            $table->bigInteger('creator')->nullable();
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
        Schema::dropIfExists('doctor_appoinments');
    }
}
