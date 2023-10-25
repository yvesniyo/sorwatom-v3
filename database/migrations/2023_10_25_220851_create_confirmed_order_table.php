<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmedOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmed_order', function (Blueprint $table) {
            $table->unsignedBigInteger('confirmed_order_id');
            $table->unsignedBigInteger('products_ordered_id');
            $table->integer('qty');
            $table->timestamp('datetime');
            $table->integer('status')->default(1);
            $table->string('invoice_number', 200);
            $table->timestamps();

            $table->foreign('products_ordered_id', 'confirmed_order_ibfk_1')->references('id')->on('products_ordered');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('confirmed_order');
    }
}
