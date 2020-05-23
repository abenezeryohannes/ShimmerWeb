<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone_number')->uniqie()->nullable();
            $table->string('facebook_id')->uniqie()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string("first_name")->nullable();
            // $table->string("sex")->nullable();
            $table->string("facebook")->unique()->nullable();
            $table->string("instagram")->unique()->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function(Blueprint $table){
                
            //update table
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
