<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('max_height_id')->nullabe();
            $table->unsignedBigInteger('min_height_id')->nullabe();
            $table->integer('min_age')->nullabe();
            $table->integer('max_age')->nullabe();
            $table->string('sex')->nullabe();
            $table->unsignedBigInteger('relationship_type_id')->nullabe();
            $table->integer('max_distance')->default(3000);
            
            $table->unsignedBigInteger('smoke_id')->nullable();
            $table->unsignedBigInteger('drink_id')->nullable();
            $table->unsignedBigInteger('kid_id')->nullable();
            $table->unsignedBigInteger('family_plan_id')->nullable();
            $table->unsignedBigInteger('education_id')->nullable();
            $table->unsignedBigInteger('religion_id')->nullable();
            $table->timestamps();
        });
        
         
        Schema::table('preferences', function(Blueprint $table){

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('kid_id')->references('id')->on('kids');
            $table->foreign('family_plan_id')->references('id')->on('family_plans');
            $table->foreign('education_id')->references('id')->on('educations');
            $table->foreign('religion_id')->references('id')->on('religions');
           
            $table->foreign('smoke_id')->references('id')->on('smokes');
            $table->foreign('drink_id')->references('id')->on('drinks');
            $table->foreign('max_height_id')->references('id')->on('heights');
            $table->foreign('min_height_id')->references('id')->on('heights');
            $table->foreign('relationship_type_id')->references('id')->on('relationship_types');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preferences');
    }
}
