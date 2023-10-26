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
            $table->string('firstname', 40);
            $table->string('lastname', 40);
            $table->string('category', 100);
            $table->string('phone')->unique('users_phone_unique');
            $table->string('email')->unique('users_email_unique');
            $table->string('password');
            $table->integer('status')->default(0);
            $table->text('address');
            $table->string('type', 2);
            $table->text('options');
            $table->text('image');
            $table->string('whatsapp_number');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('country_id', 'users_ibfk_1')->references('id')->on('countries');
            $table->foreign('category_id')->references('id')->on('user_categories');
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
