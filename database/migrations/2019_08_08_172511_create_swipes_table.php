<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSwipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swipes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('swiper_id');
            $table->unsignedBigInteger('swiped_id');
            $table->string('direction');
            $table->timestamps();
        });

        
         
        Schema::table('swipes', function(Blueprint $table){

            $table->foreign('swiper_id')->references('id')->on('users');
            $table->foreign('swiped_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swipes');
    }
}
