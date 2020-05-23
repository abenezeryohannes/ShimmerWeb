<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('completed')->default(0);
            $table->string('sex')->nullable();
            $table->unsignedBigInteger('relationship_type_id')->nullable();
            $table->unsignedBigInteger('kid_id')->nullable();
            $table->unsignedBigInteger('family_plan_id')->nullable();
            $table->unsignedBigInteger('education_id')->nullable();
            $table->unsignedBigInteger('religion_id')->nullable();
            $table->integer('age')->nullable();
            $table->unsignedBigInteger('height_id')->nullable();
            $table->string('work')->nullable();
            $table->string('job')->nullable();
            $table->string('home_town')->nullable();
            $table->string('school')->nullable();
            $table->unsignedBigInteger('drink_id')->nullable();
            $table->unsignedBigInteger('smoke_id')->nullable();
            $table->timestamps();
        });

        Schema::table('profiles', function(Blueprint $table){

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('kid_id')->references('id')->on('kids');
            $table->foreign('family_plan_id')->references('id')->on('family_plans');
            $table->foreign('education_id')->references('id')->on('educations');
            $table->foreign('religion_id')->references('id')->on('religions');
            $table->foreign('drink_id')->references('id')->on('drinks');
            $table->foreign('smoke_id')->references('id')->on('smokes');
            $table->foreign('height_id')->references('id')->on('heights');
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
        Schema::dropIfExists('profiles');
    }
}
