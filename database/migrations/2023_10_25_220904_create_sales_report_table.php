<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_report', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('quantity', 8, 2);
            $table->timestamp('date');
            $table->string('place', 100);
            $table->unsignedBigInteger('stock_request_id');
            $table->string('geolocation', 100);
            $table->string('client_name', 100);
            $table->string('client_phone', 100);
            $table->string('team', 100);
            $table->timestamps();

            $table->foreign('product_id', 'sales_report_ibfk_1')->references('id')->on('products');
            $table->foreign('stock_request_id', 'sales_report_ibfk_2')->references('id')->on('stock_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_report');
    }
}
