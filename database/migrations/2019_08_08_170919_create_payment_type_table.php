<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_types', function (Blueprint $table) {        
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('type')->default("subscribtion");
                $table->longText('short_desc');
                $table->longText('long_desc');
                $table->unsignedInteger('likes_per_day')->default(1000000);
                $table->unsignedInteger('super_likes_per_day')->default(5);
                $table->unsignedInteger('view_likes_per_day')->default(1000000);
                $table->unsignedInteger('boost_minutes')->default(0);
                $table->integer('number_of_days');
                $table->integer('price');
                $table->timestamps();
        });


        Schema::table('payment_types', function(Blueprint $table){

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_types');
    }
}
