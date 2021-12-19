<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorPrescriptionInvestigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_prescription_investigations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('prescription_id')->nullable();
            $table->string('name', 100)->nullable();
            $table->text('description')->nullable();
            
            $table->string('slug', 50)->nullable();
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
        Schema::dropIfExists('doctor_prescription_investigations');
    }
}
