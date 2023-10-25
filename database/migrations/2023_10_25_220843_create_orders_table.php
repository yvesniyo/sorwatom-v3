<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->dateTime('date');
            $table->integer('status');
            $table->double('amount');
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('modified_by');
            $table->timestamps();
            
            $table->foreign('client_id', 'orders_ibfk_1')->references('id')->on('customers');
            $table->foreign('added_by', 'orders_ibfk_2')->references('id')->on('users');
            $table->foreign('modified_by', 'orders_ibfk_3')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
