<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pharmacy_id')->nullable();
            $table->string('name',100)->nullable();
            $table->string('photo',100)->nullable();
            $table->string('photoURL',100)->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('manufacturer_id')->nullable();
            $table->bigInteger('storage_location_id')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->tinyInteger('need_prescription')->default(0);
            $table->string('scientific_name',100)->nullable();
            $table->integer('storage_temperature')->nullable();
            $table->string('dangerous_level',100)->nullable();
            $table->string('no_of_unit_in_package',100)->nullable();
            $table->string('unit_price',100)->nullable();

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
        Schema::dropIfExists('drugs');
    }
}
