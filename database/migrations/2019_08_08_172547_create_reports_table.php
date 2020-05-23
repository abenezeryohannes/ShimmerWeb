<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reporter_id');
            $table->unsignedBigInteger('reported_id');
            $table->unsignedBigInteger('case_id')->nullable();
            $table->string('text');
            $table->timestamps();
        });

        
         
        Schema::table('reports', function(Blueprint $table){

            $table->foreign('reporter_id')->references('id')->on('users');
            $table->foreign('reported_id')->references('id')->on('users');
            $table->foreign('case_id')->references('id')->on('report_cases');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
