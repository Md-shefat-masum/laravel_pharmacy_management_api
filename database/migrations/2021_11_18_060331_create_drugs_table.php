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
            $table->string('name', 100)->nullable();
            $table->string('photo', 100)->nullable();
            $table->string('photoURL', 100)->nullable();
            $table->tinyInteger('need_prescription')->default(0);
            $table->string('scientific_name', 100)->nullable();
            $table->integer('storage_temperature')->nullable();
            $table->string('dangerous_level', 100)->nullable();
            $table->string('no_of_unit_in_package', 100)->nullable();
            $table->double('unit_price')->nullable();
            $table->double('sales_price')->nullable();
            $table->double('sales_tax')->nullable();

            $table->string('creator', 100)->nullable();
            $table->string('slug', 100)->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('drug_drug_category', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('drug_id')->nullable();
            $table->bigInteger('drug_category_id')->nullable();
            $table->timestamps();
        });

        Schema::create('drug_drug_manufacturer', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('drug_id')->nullable();
            $table->bigInteger('drug_manufacturer_id')->nullable();
            $table->timestamps();
        });

        Schema::create('drug_drug_storage', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('drug_id')->nullable();
            $table->bigInteger('drug_storage_id')->nullable();
            $table->timestamps();
        });

        Schema::create('drug_user_supplier', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('drug_id')->nullable();
            $table->bigInteger('user_supplier_id')->nullable();
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

        Schema::dropIfExists('drug_drug_category');
        Schema::dropIfExists('drug_drug_manufacturer');
        Schema::dropIfExists('drug_drug_storage');
        Schema::dropIfExists('drug_user_supplier');
    }
}
