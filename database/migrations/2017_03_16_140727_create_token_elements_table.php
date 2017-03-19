<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokenElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('token_elements', function ($table) {
            $table->increments('id');
            $table->integer('website_id')->unsigned();
            $table->foreign('website_id')->references('id')->on('websites');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('url');
            $table->longText('description');
            $table->string('element_type');
            $table->string('current_headline')->nullable();
            $table->string('new_headline')->nullable();
            $table->string('current_paragraph')->nullable();
            $table->string('new_paragraph')->nullable();
            $table->string('image')->nullable();
            $table->boolean('payed');
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
        Schema::dropIfExists('token_elements');
    }
}
