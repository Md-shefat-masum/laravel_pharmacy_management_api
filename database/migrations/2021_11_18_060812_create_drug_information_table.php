<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_information', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('drug_id')->nullable();
            $table->string('manufacturing_date',100)->nullable();
            $table->string('expiry_date',100)->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->string('date_of_entry',20)->nullable();
            $table->text('indication')->nullable();
            $table->longText('dosage_and_administration')->nullable();
            $table->text('preparation')->nullable();

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
        Schema::dropIfExists('drug_information');
    }
}
