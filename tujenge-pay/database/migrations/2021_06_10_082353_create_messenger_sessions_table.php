<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessengerSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messenger_sessions', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->string('sender');
            $table->uuid('bot_session_id')->index();
            $table->uuid('messenger_account_id')->index();
            $table->string('session_status')->default('active');

            $table->foreign('messenger_account_id')
                ->references('id')
                ->on('messenger_accounts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('bot_session_id')
                ->references('id')
                ->on('bot_sessions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
        Schema::dropIfExists('messenger_sessions');
    }
}
