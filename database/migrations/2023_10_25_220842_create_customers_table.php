<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('company', 256);
            $table->string('phone', 15)->unique('customers_phone_unique');
            $table->string('type', 40);
            $table->text('address');
            $table->string('road', 40);
            $table->dateTime('created_date');
            $table->integer('status');
            $table->text('location');
            $table->string('whatsapp_number', 40);
            $table->text('tva_pic');
            $table->text('id_pic');
            $table->text('company_reg_pic');
            $table->string('country', 256);
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
        Schema::dropIfExists('customers');
    }
}
