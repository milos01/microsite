<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokenElementOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('element_orders', function ($table) {
            $table->increments('id');
            $table->integer('element_id')->unsigned();
            $table->foreign('element_id')->references('id')->on('token_elements');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('token_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('element_orders');
    }
}
