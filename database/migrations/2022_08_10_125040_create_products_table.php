<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_category')->unsigned();
            $table->text('thumbnail');
            $table->string('brand');
            $table->string('code');
            $table->string('name');
            $table->longText('description');
            $table->bigInteger('price');
            $table->integer('stock_quantity');
            $table->enum('is_deleted', array('0','1'))->default('0');
            $table->enum('status', array('0','1'))->default('1');
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
