<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('match_id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('reciever_id');
            $table->string('message');
            $table->boolean('status')->nullable();
            $table->boolean('seen')->default(true);
            $table->timestamps();
        });

        
         
        Schema::table('messages', function(Blueprint $table){

            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('match_id')->references('id')->on('matches');
            $table->foreign('reciever_id')->references('id')->on('users');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
