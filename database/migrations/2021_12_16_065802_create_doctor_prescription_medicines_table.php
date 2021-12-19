<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorPrescriptionMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_prescription_medicines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('prescription_id')->nullable();
            $table->string('name',100)->nullable();
            $table->integer('days')->nullable();
            $table->text('description')->nullable();

            $table->boolean('morning')->nullable();
            $table->boolean('afternoon')->nullable();
            $table->boolean('evening')->nullable();
            $table->boolean('night')->nullable();
            $table->boolean('before_eat')->nullable();
            $table->boolean('after_eat')->nullable();
            $table->boolean('empty_stomach')->nullable();

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
        Schema::dropIfExists('doctor_prescription_medicines');
    }
}
