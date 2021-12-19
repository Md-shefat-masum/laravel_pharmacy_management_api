<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_code',20)->nullable();
            $table->string('first_name',30)->nullable();
            $table->string('last_name',30)->nullable();
            $table->string('user_name',30)->unique();
            $table->bigInteger('role_serial')->nullable();
            $table->string('email')->unique();
            $table->string('contact_number',20)->unique();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->string('photo',100)->default('/avatar.png');
            $table->string('dob',30)->nullable();
            $table->string('gender',30)->nullable();
            $table->string('street',100)->nullable();
            $table->string('city',50)->nullable();
            $table->string('country',50)->nullable();
            $table->string('state',50)->nullable();
            $table->string('zip_code',100)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',100);
            $table->rememberToken();

            $table->bigInteger('creator')->nullable();
            $table->string('slug',100)->nullable();
            $table->string('status',20)->default('active');
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
        Schema::dropIfExists('users');
    }
}
