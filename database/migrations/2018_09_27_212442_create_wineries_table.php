<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWineriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wineries', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('sub_name')->nullable();
            $table->string('region');
            $table->string('sub_region')->nullable(); 
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->integer('zip');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('web_url')->nullable();
            $table->boolean('dining');
            $table->string('logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wineries');
    }
}
