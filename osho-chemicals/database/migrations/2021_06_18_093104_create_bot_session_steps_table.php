<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBotSessionStepsTable extends Migration
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
            $table->integer('session_step_key');
            $table->boolean('is_initial_step');
            $table->boolean('with_input');
            $table->integer('next_session_step_key');
            $table->string('reply_type')->nullable();
            $table->string('button_header_type')->nullable();

            $table->boolean('is_next_step_session')->nullable();
            $table->string('next_session')->nullable();


            $table->boolean('back_to_session')->nullable();
            $table->string('previous_session_name')->nullable();
            $table->boolean('allow_back')->nullable();
            $table->integer('previous_session_step')->nullable();

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
