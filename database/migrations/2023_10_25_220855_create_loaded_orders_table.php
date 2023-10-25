<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadedOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loaded_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('confirmed_order_id');
            $table->unsignedBigInteger('car_id');
            $table->unsignedBigInteger('driver_id');
            $table->timestamp('datetime');
            $table->integer('status')->default(1);
            $table->timestamps();

            $table->foreign('car_id', 'loaded_orders_ibfk_1')->references('id')->on('cars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loaded_orders');
    }
}
