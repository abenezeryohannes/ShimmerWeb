<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelegramInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_invites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullabe();
            $table->unsignedBigInteger('confirmation_code');
            $table->boolean('confirmed')->default(false);
            $table->string('invitation_link')->nullable();
            $table->string('telegram_user_name');
            $table->string('telegram_id')->nullable();
            $table->integer("total_approve")->default(0);
            $table->timestamps();
        });

        Schema::table('telegram_invites', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('telegram_invites');
    }
}
