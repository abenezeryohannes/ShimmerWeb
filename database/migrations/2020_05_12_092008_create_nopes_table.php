<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nopes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('noper_id');
            $table->unsignedBigInteger('noped_id');
            $table->timestamps();
        });

        Schema::table('nopes', function(Blueprint $table){
            $table->foreign('noper_id')->references('id')->on('users');
            $table->foreign('noped_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nopes');
    }
}
