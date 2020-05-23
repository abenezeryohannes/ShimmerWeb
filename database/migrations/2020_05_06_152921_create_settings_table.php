<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('free_likes_per_day')->default(20);
            $table->unsignedInteger('free_boosts_per_month')->default(1);
            $table->unsignedInteger('free_super_likes_per_month')->default(5);
            $table->unsignedInteger('boost_minutes')->default(60);
            $table->string('phone_number')->default("910406268");
            $table->string('bank_account')->default("999999999999999999");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
