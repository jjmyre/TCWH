<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('order');
            $table->boolean('pending')->default(0);
            $table->integer('user_id')->unsigned();
            $table->integer('winery_id')->unsigned();
            
            #Foreign Keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('winery_id')->references('id')->on('wineries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
