<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaWineryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ava_winery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('winery_id')->unsigned();
            $table->integer('ava_id')->unsigned();

            #Foreign Keys
            $table->foreign('winery_id')->references('id')->on('wineries');
            $table->foreign('ava_id')->references('id')->on('avas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ava_winery');
    }
}
