<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_data', function (Blueprint $table) {
            $table->id();
            $table->string('device_name', 100);
            $table->string('air_temp', 100);
            $table->string('soil_temp', 100);
            $table->string('soil_moist', 100);
            $table->string('air_hum', 100);
            $table->string('lat', 100);
            $table->string('lon', 100);
            $table->timestamp('date_in');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collection_data');
    }
}
