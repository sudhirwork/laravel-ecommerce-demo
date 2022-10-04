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
            $table->bigInteger('id_customer')->unsigned();
            $table->bigInteger('id_product')->unsigned();
            $table->string('order_no');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->bigInteger('mobile');
            $table->longText('address_line_1');
            $table->longText('address_line_2');
            $table->bigInteger('city');
            $table->bigInteger('state');
            $table->bigInteger('country');
            $table->integer('zipcode');
            $table->string('name');
            $table->string('brand');
            $table->string('code');
            $table->bigInteger('price');
            $table->integer('quantity');
            $table->bigInteger('subtotal');
            $table->enum('track_status', array('not dispatch','dispatched','on the way','way to home','deliverd'))->default('not dispatch');
            $table->enum('is_deleted', array('0','1'))->default('0');
            $table->enum('status', array('0','1'))->default('1');
            $table->foreign('id_customer')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('id_product')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
