<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitorsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitors_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name', 256);
            $table->integer('product_price');
            $table->unsignedBigInteger('competitor_id');
            $table->integer('status');
            $table->dateTime('date_added');
            $table->dateTime('date_modified');
            $table->text('remark');
            $table->unsignedBigInteger('added_by');
            $table->timestamps();
            
            $table->foreign('competitor_id', 'competitors_products_ibfk_1')->references('id')->on('competitors');
            $table->foreign('added_by', 'competitors_products_ibfk_2')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competitors_products');
    }
}
