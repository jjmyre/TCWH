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
            $table->integer('user_id')->unsigned();
            $table->integer('1')->unique()->nullable()->unsigned();
            $table->integer('2')->unique()->nullable()->unsigned();
            $table->integer('3')->unique()->nullable()->unsigned();
            $table->integer('4')->unique()->nullable()->unsigned();
            $table->integer('5')->unique()->nullable()->unsigned();
            $table->integer('6')->unique()->nullable()->unsigned();
            $table->integer('7')->unique()->nullable()->unsigned();
            $table->integer('8')->unique()->nullable()->unsigned();
            $table->integer('9')->unique()->nullable()->unsigned();

            # Foreign keys connect to `id` field in wineries table
            $table->foreign('1')->references('id')->on('wineries');
            $table->foreign('2')->references('id')->on('wineries');
            $table->foreign('3')->references('id')->on('wineries');
            $table->foreign('4')->references('id')->on('wineries');
            $table->foreign('5')->references('id')->on('wineries');
            $table->foreign('6')->references('id')->on('wineries');
            $table->foreign('7')->references('id')->on('wineries');
            $table->foreign('8')->references('id')->on('wineries');
            $table->foreign('9')->references('id')->on('wineries');

            # Foreign key connects to `id` field in users table
            $table->foreign('user_id')->references('id')->on('users');
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
