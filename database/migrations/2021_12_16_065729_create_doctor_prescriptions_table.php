<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorPrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('appoinment_id')->nullable();
            $table->bigInteger('doctor_id')->nullable();
            $table->bigInteger('consumer_id')->nullable();
            $table->text('additional_message')->nullable();
            $table->longText('additional_field')->nullable();

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
        Schema::dropIfExists('doctor_prescriptions');
    }
}
