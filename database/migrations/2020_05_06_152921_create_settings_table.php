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
            $table->unsignedInteger('free_likes_per_day')->default(10);
            $table->unsignedInteger('free_boosts_per_month')->default(0);
            $table->unsignedInteger('free_super_likes_per_month')->default(5);
            $table->unsignedInteger('boost_minutes')->default(120);
            $table->unsignedInteger('free_tg_invitation')->default(7);
            $table->string('phone_number')->default("934333297");
            $table->string('bank_account')->default("1000197219387");
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
