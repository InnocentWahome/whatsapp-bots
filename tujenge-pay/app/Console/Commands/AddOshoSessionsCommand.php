<?php

namespace App\Console\Commands;

use App\Models\BotResponse;
use App\Models\BotSession;
use App\Models\BotSessionStep;
use Illuminate\Console\Command;

class AddOshoSessionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:osho-bot';

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
            'session_name' => 'osho',
            'channel' => 'WA',
            'session_steps' => [
                [
                    'channel' => 'WA',
                    'is_initial_step' => true,
                    'session_step' => 0,
                    'step_title' => "Hi there, I'm mkulima Joe, I'm here to help you get the right chemicals for for Crop protection, Animal Health, Public Health, Industrial Chemicals, Farm Equipment and so much more...\n\nTo start, please register by typing your name below",
                    'next_session_step' => 1,
                    'with_input' => 1,
                    'responses' => [
                        [
                            'channel' => 'WA',
                            'key_word' => 1,
                            'response_text' => '',
                            'show_step_id' => 0,
                            'next_session_step' => 0
                        ]
                    ]
                ],
                [
                    'channel' => 'WA',
                    'is_initial_step' => false,
                    'session_step' => 1,
                    'step_title' => '',
                    'next_session_step' => 2,
                    'with_input' => 1,
                    'responses' => [
                        [
                            'channel' => 'WA',
                            'key_word' => 1,
                            'show_step_id' => 0,
                            'response_text' => 'Great, now please tell us which county you are in ?',
                            'next_session_step' => 2
                        ]
                    ]
                ],
                [
                    'channel' => 'WA',
                    'is_initial_step' => false,
                    'session_step' => 2,
                    'step_title' => "Welcome to Osho Chemicals. How may we help you? Please choose an option below to start\n\n",
                    'next_session_step' => 3,
                    'with_input' => 0,
                    'responses' => [
                        [
                            'channel' => 'WA',
                            'key_word' => 1,
                            'show_step_id' => 1,
                            'response_text' => 'Enquiry',
                            'next_session_step' => 3
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 2,
                            'show_step_id' => 1,
                            'response_text' => 'Find an Agrovet/Agro dealer',
                            'next_session_step' => 11
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 3,
                            'show_step_id' => 1,
                            'response_text' => 'Contact Osho Chemicals Industry Ltd',
                            'next_session_step' => 15
                        ]
                    ]
                ],
                [
                    'channel' => 'WA',
                    'is_initial_step' => false,
                    'session_step' => 2,
                    'step_title' => "Welcome to Osho Chemicals. How may we help you? Please choose an option below to start\n\n",
                    'next_session_step' => 3,
                    'with_input' => 0,
                    'responses' => [
                        [
                            'channel' => 'WA',
                            'key_word' => 1,
                            'show_step_id' => 1,
                            'response_text' => 'Enquiry',
                            'next_session_step' => 3
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 2,
                            'show_step_id' => 1,
                            'response_text' => 'Find an Agrovet/Agro dealer',
                            'next_session_step' => 11
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 3,
                            'show_step_id' => 1,
                            'response_text' => 'Contact Osho Chemicals Industry Ltd',
                            'next_session_step' => 15
                        ]
                    ]
                ],
                [
                    'channel' => 'WA',
                    'is_initial_step' => false,
                    'session_step' => 3,
                    'step_title' => "Please chose an option below\n\n",
                    'next_session_step' => 4,
                    'with_input' => 0,
                    'responses' => [
                        [
                            'channel' => 'WA',
                            'key_word' => 1,
                            'show_step_id' => 1,
                            'response_text' => 'Crop disease inquiry',
                            'next_session_step' => 4
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 2,
                            'show_step_id' => 1,
                            'response_text' => 'Product inquiry',
                            'next_session_step' => 4
                        ]
                    ]
                ],
                [
                    'channel' => 'WA',
                    'is_initial_step' => false,
                    'session_step' => 4,
                    'step_title' => "What crop would you like to know about?\n\n",
                    'next_session_step' => 5,
                    'with_input' => 0,
                    'responses' => [
                        [
                            'channel' => 'WA',
                            'key_word' => 1,
                            'show_step_id' => 1,
                            'response_text' => "Tomatoes",
                            'next_session_step' => 5
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 2,
                            'show_step_id' => 1,
                            'response_text' => "Maize",
                            'next_session_step' => 5
                        ]
                    ]
                ],
                [
                    'channel' => 'WA',
                    'is_initial_step' => false,
                    'session_step' => 5,
                    'step_title' => "Please chose an option below\n\n",
                    'next_session_step' => 6,
                    'with_input' => 0,
                    'responses' => [
                        [
                            'channel' => 'WA',
                            'key_word' => 1,
                            'show_step_id' => 1,
                            'response_text' => "Whiteflies",
                            'next_session_step' => 6
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 2,
                            'show_step_id' => 1,
                            'response_text' => "Aphids",
                            'next_session_step' => 5
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 3,
                            'show_step_id' => 1,
                            'response_text' => "Thrips",
                            'next_session_step' => 5
                        ]
                    ]
                ],
                [
                    'channel' => 'WA',
                    'is_initial_step' => false,
                    'session_step' => 6,
                    'step_title' => "To eradicate Whiteflies, Use Alpha degree (20mls/20L of water).\n\nAre you satisfied with the response you have received?\n\nPlease reply with an option below\n\n",
                    'next_session_step' => 7,
                    'with_input' => 0,
                    'responses' => [
                        [
                            'channel' => 'WA',
                            'key_word' => 1,
                            'show_step_id' => 1,
                            'response_text' => "Yes",
                            'next_session_step' => 7
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 2,
                            'show_step_id' => 1,
                            'response_text' => "No",
                            'next_session_step' => 8
                        ]
                    ]
                ],
                [
                    'channel' => 'WA',
                    'is_initial_step' => false,
                    'session_step' => 7,
                    'step_title' => "Thank you for being our valued customer",
                    'next_session_step' => 9,
                    'with_input' => 0,
                    'responses' => [
                        [
                            'channel' => 'WA',
                            'key_word' => 1,
                            'show_step_id' => 0,
                            'response_text' => "",
                            'next_session_step' => 9
                        ]
                    ]
                ],
                [
                    'channel' => 'WA',
                    'is_initial_step' => false,
                    'session_step' => 8,
                    'step_title' => "To speak to an agent, please send us a direct email on customercare@oshochem.com,\n\nor call us on (+254) 0711 045 000 or send us a message on 20560",
                    'next_session_step' => 10,
                    'with_input' => 0,
                    'responses' => [
                        [
                            'channel' => 'WA',
                            'key_word' => 1,
                            'show_step_id' => 0,
                            'response_text' => "",
                            'next_session_step' => 10
                        ]
                    ]
                ],
                [
                    'channel' => 'WA',
                    'is_initial_step' => false,
                    'session_step' => 11,
                    'step_title' => "Are you a Stockist?\n\n",
                    'next_session_step' => 12,
                    'with_input' => 0,
                    'responses' => [
                        [
                            'channel' => 'WA',
                            'key_word' => 1,
                            'show_step_id' => 1,
                            'response_text' => "Yes",
                            'next_session_step' => 12
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 2,
                            'show_step_id' => 1,
                            'response_text' => "No",
                            'next_session_step' => 15
                        ]
                    ]
                ],
                [
                    'channel' => 'WA',
                    'is_initial_step' => false,
                    'session_step' => 12,
                    'step_title' => "Please chose your county below to get an Agrovet/Agrodealer.\n\n",
                    'next_session_step' => 13,
                    'with_input' => 0,
                    'responses' => [
                        [
                            'channel' => 'WA',
                            'key_word' => 1,
                            'show_step_id' => 1,
                            'response_text' => "Bomet",
                            'next_session_step' => 13
                        ]
                    ]
                ],
                [
                    'channel' => 'WA',
                    'is_initial_step' => false,
                    'session_step' => 13,
                    'step_title' => "Here is a list of Agrovet Suppliers in Bomet County\n\n",
                    'next_session_step' => 15,
                    'with_input' => 0,
                    'responses' => [
                        [
                            'channel' => 'WA',
                            'key_word' => 1,
                            'show_step_id' => 1,
                            'response_text' => "SAI AGROVET LTD-+254703535252",
                            'next_session_step' => 15
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 2,
                            'show_step_id' => 1,
                            'response_text' => "SOT PHARMACY-+254720283240",
                            'next_session_step' => 15
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 3,
                            'show_step_id' => 1,
                            'response_text' => "ISENYA FARM INPUT STORES-+254720344266",
                            'next_session_step' => 15
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 4,
                            'show_step_id' => 1,
                            'response_text' => "SHRIJI AGROVET LTD-+254723250397",
                            'next_session_step' => 15
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 5,
                            'show_step_id' => 1,
                            'response_text' => "MEDS PHARMACEUTICALS LTD-+254723478529",
                            'next_session_step' => 15
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 6,
                            'show_step_id' => 1,
                            'response_text' => "Are you satisfied with the response you have received? - Yes",
                            'next_session_step' => 15
                        ],
                        [
                            'channel' => 'WA',
                            'key_word' => 7,
                            'show_step_id' => 1,
                            'response_text' => "Are you satisfied with the response you have received? - No",
                            'next_session_step' => 15
                        ]
                    ]
                ],
                [
                    'channel' => 'WA',
                    'is_initial_step' => false,
                    'session_step' => 15,
                    'step_title' => "Hi! you can contact us through the details below\n\nPhysical address: Osho complex, sasio road, off lunga lunga industrial area, Nairobi Kenya\n\nTel: (+254) 0711 045000/0732167000/020 321000\n\nEmail:oshochem@oshochem.com\n\nSMS:20560\n\nWebsite Url:http://oshochem.com\n\nFacebook:https://web.facebook.com/OshoChem\n\nTwitter url:https://twitter.com/Oshochem",
                    'next_session_step' => 16,
                    'with_input' => 0,
                    'responses' => [
                        [
                            'channel' => 'WA',
                            'key_word' => 1,
                            'show_step_id' => 0,
                            'response_text' => "",
                            'next_session_step' => 16
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

                        $bot_response->channel = 'TE';
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
