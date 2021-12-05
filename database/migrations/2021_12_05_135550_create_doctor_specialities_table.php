<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorSpecialitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_specialities', function (Blueprint $table) {
            $table->id();
            $table->string('title',100)->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
        Schema::create('doctor_speciality_user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('doctor_speciality_id')->nullable();
            $table->bigInteger('user_id')->nullable();
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
        Schema::dropIfExists('doctor_specialities');
        Schema::dropIfExists('doctor_speciality_user');
    }
}
