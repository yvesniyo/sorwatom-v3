<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceBelongingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_belonging', function (Blueprint $table) {
            $table->id();
            $table->string('device_id', 40)->unique('device_belonging_device_id_unique');
            $table->unsignedBigInteger('user_id')->unique('device_belonging_user_id_unique');
            $table->timestamps();
            
            $table->foreign('user_id', 'device_belonging_ibfk_1')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_belonging');
    }
}
