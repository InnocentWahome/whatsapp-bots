<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeBotSessionStepsTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_session_steps', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->uuid('bot_session_id')->index();
            $table->string('channel');
            $table->text('step_title')->nullable();
            $table->json('service_methods')->nullable();
            $table->string('response_source')->default('app');
            $table->string('response_function')->nullable();
            $table->string('reply_type')->nullable();
            $table->integer('session_step_key');
            $table->boolean('is_initial_step');
            $table->boolean('with_input');
            $table->string('next_session_step_key');

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
        Schema::dropIfExists('bot_session_steps');
    }
}
