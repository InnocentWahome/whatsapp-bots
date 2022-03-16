<?php

namespace App\Console\Commands;

use App\Models\BotResponse;
use App\Models\BotSession;
use App\Models\BotSessionStep;
use Illuminate\Console\Command;

class AddUdaSessionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:uda-bot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bot_sessions = [
            [
                'session_name' => 'uda',
                'channel' => 'WA',
                'session_switching' => 0,
                'session_key_word' => 0,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Hello, Welcome to UDA party, Would you like to sign up as a UDA party member?\n\nPlease reply with an option below\n\n",
                        'next_session_step' => 1,
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => 'Register as a member',
                                'show_step_id' => 1,
                                'next_session_step' => 1
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 1,
                        'step_title' => "Thank you for choosing to register as a UDA party member\n\n",
                        'next_session_step' => 2,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => 'Please reply with your name',
                                'next_session_step' => 2
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 2,
                        'step_title' => "Great!Now please type in your I.D number\n\n",
                        'next_session_step' => 3,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => '',
                                'next_session_step' => 3
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 3,
                        'step_title' => "Great. Finally, please type in your email address.\n\n",
                        'next_session_step' => 4,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => '',
                                'next_session_step' => 4
                            ]
                        ]
                    ],
                    [
                        'channel' => 'WA',
                        'is_initial_step' => false,
                        'session_step' => 4,
                        'step_title' => "Success! Thank you for registering to be a member of UDA party\n\n",
                        'next_session_step' => 5,
                        'with_input' => 1,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => '',
                                'next_session_step' => 5
                            ]

                        ]
                    ]
                ]
            ]
        ];

        foreach ($bot_sessions as $bot_session) {

            if (!BotSession::where('session_name', $bot_session['session_name'])
                ->where('channel', $bot_session['channel'])
                ->exists()) {

                $bot_session_model = new BotSession();

                $bot_session_model->session_name = $bot_session['session_name'];
                $bot_session_model->session_key_word = $bot_session['session_key_word'];
                $bot_session_model->channel = $bot_session['channel'];

                $bot_session_model->save();
            } else {

                $bot_session_model = BotSession::where('session_name', $bot_session['session_name'])
                    ->where('channel', $bot_session['channel'])
                    ->first();
            }

            foreach ($bot_session['session_steps'] as $session_step) {

                if (!BotSessionStep::where('session_step_key', $session_step['session_step'])
                    ->where('bot_session_id', $bot_session_model->id)
                    ->where('channel', $bot_session['channel'])
                    ->exists()) {

                    $bot_session_step = new BotSessionStep();

                    $bot_session_step->bot_session_id = $bot_session_model->id;
                    $bot_session_step->session_step_key = $session_step['session_step'];
                    $bot_session_step->next_session_step_key = $session_step['next_session_step'];
                    $bot_session_step->channel = $session_step['channel'];
                    $bot_session_step->step_title = $session_step['step_title'];
                    $bot_session_step->is_initial_step = $session_step['is_initial_step'];
                    $bot_session_step->with_input = $session_step['with_input'];

                    $bot_session_step->save();
                } else {

                    $bot_session_step = BotSessionStep::where('session_step_key', $session_step['session_step'])
                        ->where('channel', $bot_session['channel'])
                        ->first();
                }

                foreach ($session_step['responses'] as $response) {

                    if (!BotResponse::where('response_text', $response['response_text'])
                        ->where('bot_session_step_id', $bot_session_step->id)
                        ->where('channel', $bot_session['channel'])
                        ->exists()) {

                        $bot_response = new BotResponse();

                        $bot_response->channel = $bot_session['channel'];
                        $bot_response->bot_session_id = $bot_session_model->id;
                        $bot_response->bot_session_step_id = $bot_session_step->id;
                        $bot_response->key_word = $response['key_word'];
                        $bot_response->response_text = $response['response_text'];
                        $bot_response->show_step_id = $response['show_step_id'];
                        $bot_response->next_session_step = $response['next_session_step'];

                        $bot_response->save();
                    }
                }
            }
        }
    }
}
