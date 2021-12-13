<?php

namespace App\Console\Commands;

use App\Models\BotSession;
use App\Models\BotResponse;
use App\Models\BotSessionStep;
use Illuminate\Console\Command;

class AddBotSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:bot-chatbot';

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
                'session_name' => 'hi',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 0,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Hello, welcome to Emalify, a one\nstop communication platform solution.\nHow may we help? Please choose\nan option below.\n\n",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'response_text' => 'SMS',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 2,
                                'response_text' => 'Airtime',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 3,
                                'response_text' => 'Voice service',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 4,
                                'response_text' => 'Payments',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 5,
                                'response_text' => 'Chats',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 6,
                                'response_text' => 'USSD Codes',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ],
                            [
                                'channel' => 'WA',
                                'key_word' => 7,
                                'response_text' => 'Survey',
                                'show_step_id' => 1,
                                'next_session_step' => 1,
                                'previous_session_step' => null,
                            ]
                        ]
                    ]

                ]
            ],
            [
                'session_name' => 'sms',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 1,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Thanks for reaching out, someone will\nget intouch with you very shortly.\n\nIn the meantime please visit https://emalify.com/ to create an account.🙂",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "",
                                'next_session_step' => 1
                            ]

                        ]
                    ]

                ]
            ],
            [
                'session_name' => 'airtime',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 2,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Thanks for reaching out, someone will\nget intouch with you very shortly.\n\nIn the meantime please visit https://emalify.com/ to create an account.🙂",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "",
                                'next_session_step' => 1
                            ]

                        ]
                    ]

                ]
            ],
            [
                'session_name' => 'voice',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 3,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Thanks for reaching out, someone will\nget intouch with you very shortly.\n\nIn the meantime please visit https://emalify.com/ to create an account.🙂",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "",
                                'next_session_step' => 1
                            ]

                        ]
                    ]

                ]
            ],
            [
                'session_name' => 'payments',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 4,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Thanks for reaching out, someone will\nget intouch with you very shortly.\n\nIn the meantime please visit https://emalify.com/ to create an account.🙂",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "",
                                'next_session_step' => 1
                            ]

                        ]
                    ]

                ]
            ],
            [
                'session_name' => 'chats',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 5,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Thanks for reaching out, someone will\nget intouch with you very shortly.\n\nIn the meantime please visit https://emalify.com/ to create an account.🙂",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "",
                                'next_session_step' => 1
                            ]

                        ]
                    ]

                ]
            ],
            [
                'session_name' => 'ussd',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 6,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Thanks for reaching out to ussd, someone will\nget intouch with you very shortly.\n\nIn the meantime please visit https://emalify.com/ to create an account.🙂",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "",
                                'next_session_step' => 1
                            ]

                        ]
                    ]

                ]
            ],
            [
                'session_name' => 'survey',
                'channel' => 'WA',
                'session_switching' => 1,
                'session_key_word' => 7,
                'session_steps' => [
                    [
                        'channel' => 'WA',
                        'is_initial_step' => true,
                        'session_step' => 0,
                        'step_title' => "Thanks for reaching out, someone will\nget intouch with you very shortly.\n\nIn the meantime please visit https://emalify.com/ to create an account.🙂",
                        'next_session_step' => 1,
                        'back_to_session' => false,
                        'previous_session_name' => null,
                        'allow_back' => false,
                        'previous_session_step' => null,
                        'with_input' => 0,
                        'responses' => [
                            [
                                'channel' => 'WA',
                                'key_word' => 1,
                                'show_step_id' => 0,
                                'response_text' => "",
                                'next_session_step' => 1
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
                    $bot_session_step->service_methods = array_key_exists('service_methods', $session_step) ? json_encode($session_step['service_methods']) : null;
                    $bot_session_step->back_to_session = array_key_exists('back_to_session', $session_step) ? $session_step['back_to_session'] : null;
                    $bot_session_step->previous_session_name = array_key_exists('previous_session_name', $session_step) ? $session_step['previous_session_name'] : null;
                    $bot_session_step->allow_back = array_key_exists('allow_back', $session_step) ? $session_step['allow_back'] : null;
                    $bot_session_step->previous_session_step = array_key_exists('previous_session_step', $session_step) ? $session_step['previous_session_step'] : null;


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

                        $bot_response->channel = $response['channel'];
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
