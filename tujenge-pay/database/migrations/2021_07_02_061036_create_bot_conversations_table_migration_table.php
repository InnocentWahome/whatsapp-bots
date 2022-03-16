<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBotConversationsTableMigrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_conversations', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->uuid('bot_account_id');
            $table->string('channel');
            $table->unsignedBigInteger('conversation_id');

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
        Schema::dropIfExists('bot_conversations');
    }
}
