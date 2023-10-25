<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitors', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->string('product_name', 256);
            $table->string('retailer_price', 11);
            $table->string('reseller_price', 11);
            $table->text('remarks');
            $table->text('pictures');
            $table->unsignedBigInteger('added_by');
            $table->text('user_location');
            $table->text('supplier');
            $table->string('country_code', 11);
            $table->timestamps();
            
            $table->foreign('added_by', 'competitors_ibfk_1')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competitors');
    }
}
