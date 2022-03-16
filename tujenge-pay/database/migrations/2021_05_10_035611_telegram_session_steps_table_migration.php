<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TelegramSessionStepsTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_session_steps', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->uuid('telegram_session_id')->index();
            $table->uuid('telegram_account_id')->index();
            $table->uuid('bot_session_step_id')->index();
            $table->string('status')->default('active');

            $table->foreign('telegram_session_id')
                ->references('id')
                ->on('telegram_sessions')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('telegram_account_id')
                ->references('id')
                ->on('telegram_accounts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('bot_session_step_id')
                ->references('id')
                ->on('bot_session_steps')
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
        Schema::dropIfExists('telegram_session_steps');
    }
}
