<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCountryPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_country_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('country_id');
            $table->decimal('price', 8, 2);
            $table->integer('status')->default(1);
            $table->timestamps();
            
            $table->foreign('product_id', 'product_country_prices_ibfk_1')->references('id')->on('products');
            $table->foreign('country_id', 'product_country_prices_ibfk_2')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_country_prices');
    }
}
