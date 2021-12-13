<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_sessions', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->string('phone_number');
            $table->uuid('bot_session_id')->index();
            $table->uuid('whatsapp_account_id')->index();
            $table->string('session_status')->default('active');

            $table->foreign('whatsapp_account_id')
                  ->references('id')
                  ->on('whatsapp_accounts')
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
        Schema::dropIfExists('whatsapp_sessions');
    }
}
