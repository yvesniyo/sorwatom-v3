<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('province', 256);
            $table->string('district', 256);
            $table->string('street', 256);
            $table->string('receiver_name', 256);
            $table->integer('quantity');
            $table->integer('status');
            $table->dateTime('delivery_date');
            $table->timestamps();
            
            $table->foreign('order_id', 'deliveries_ibfk_1')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
