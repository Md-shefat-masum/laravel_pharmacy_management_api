<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDoctorInformaionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_doctor_informaions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('doctor_id')->nullable();
            $table->float('doctor_charge')->nullable();
            $table->text('education')->nullable();
            $table->text('experience')->nullable();
            $table->text('schedule')->nullable();
            $table->string('supported_insurance',100)->nullable();
            $table->string('professor_membership_id',100)->nullable();
            $table->text('licence_no')->nullable();
            $table->text('language_spoken')->nullable();
            $table->string('prof_membership',100)->nullable();

            $table->string('creator',100)->nullable();
            $table->string('slug',100)->nullable();
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
        Schema::dropIfExists('user_doctor_informaions');
    }
}
