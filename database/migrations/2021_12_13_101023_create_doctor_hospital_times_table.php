<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorHospitalTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_hospital_times', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('hospital_id')->nullable();
            $table->bigInteger('doctor_id')->nullable();
            $table->string('day',15)->nullable();
            $table->string('start_time',15)->nullable();
            $table->string('end_time',15)->nullable();
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
        Schema::dropIfExists('doctor_hospital_times');
    }
}
