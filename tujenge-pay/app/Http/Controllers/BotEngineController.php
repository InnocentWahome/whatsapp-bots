<?php

namespace App\Http\Controllers;

use App\CustomerCare;
use App\Models\BotConversation;
use App\Models\UniqueWhatsappMessage;
use App\Models\WhatsappOtpCode;
use App\Notifications\SendCustomerMessageNotification;
use App\Repositories\BotSessionRepository;
use App\Repositories\MessengerAccountRepository;
use App\Repositories\MessengerSessionRepository;
use App\Repositories\TelegramAccountRepository;
use App\Repositories\TelegramSessionRepository;
use App\Repositories\WhatsappAccountRepository;
use App\Repositories\WhatsappSessionRepository;
use App\Services\BotAccountsService;
use App\Services\BotServices;
use App\Services\BotSessionService;
use App\Services\WhatsAppServiceApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;

class BotEngineController extends Controller
{
    public function botEngine(Request $request,
                              BotAccountsService $botAccountsService,
                              BotSessionService $botSessionService,
                              WhatsappSessionRepository $whatsappSessionRepository,
                              BotSessionRepository $botSessionRepository,
                              BotServices $botServices,
                              WhatsAppServiceApi $whatsAppServiceApi)
    {

        if (env('WA_BOT_ENV') == 'TWILIO') {

            // Get all the data from the user input
            $data = $request->all();

            // Get the WhatsApp number making the request
            $from = $data['From'];

            Log::info('FROM WHATSAPP NUMBER : ' . $from);

            // We remove all whitespaces from the body
            $body = $string = preg_replace('/\s+/', '', $data['Body']);

            // If a media exixts, we retrieve the media url
            $media_url0 = array_key_exists('MediaUrl0', $data) ? $data['MediaUrl0'] : null;

            Log::info('MEDIA0 : ' . $media_url0);

            // We truncate the WhatsApp number from the 13th character
            $truncated_number = substr($from, 13);

            // We create the number starting with 0
            $phone_number = '0' . $truncated_number;

            // We create the WhatsApp number by adding +254
            $whatsapp_number = '+254' . $truncated_number;

            $latitude = array_key_exists('Latitude', $data) ? $data['Latitude'] : null;

            $longitude = array_key_exists('Longitude', $data) ? $data['Longitude'] : null;

            $address = array_key_exists('Address', $data) ? $data['Address'] : null;

            Log::info('Latitude : ' . $latitude);
            Log::info('Longitude : ' . $longitude);
            Log::info('Address : ' . $address);


            Log::info('Body : ' . $body);

//        Log::info('Emoji : '. Emoji::Encode($body));

            $channel = 'WA'; //$request->channel;
            $user_identifier = $whatsapp_number;
            $message = $body;

            $message_from = $from;

            $message_body = $data['Body'];
        }

        if (env('WA_BOT_ENV') == '360') {

//            file_put_contents("data.json", $json = response()->json($request->all()));

            Log::info('NEW BOT HIT');

            $data = $request->all();

            $messages = isset($data['messages']) ? $data['messages'] : 'n/a';

            if ($messages == 'n/a') {
                return 'ok';
            }

            $first_message = $messages[0];

            $message_from = isset($first_message['from']) ? $first_message['from'] : 'n/a';
            $message_text = isset($first_message['text']) ? $first_message['text'] : 'n/a';
            $message_body = isset($message_text['body']) ? $message_text['body'] : 'n/a';
            $message_id = isset($first_message['id']) ? $first_message['id'] : 'n/a';
            $message_name = isset($first_message['type']) ? $first_message['type'] : 'n/a';

            $environment = isset($data[0]['environment']) ? $data[0]['environment'] : 'n/a';
            $events = isset($data[0]['events']) ? $data[0]['events'] : 'n/a';
            $device = isset($data[0]['device']) ? $data[0]['device'] : 'n/a';
            $recipient_id = isset($data[0]['recipient_id']) ? $data[0]['recipient_id'] : 'n/a';

            $app_id = isset($environment['app_id']) ? $environment['app_id'] : 'n/a';

            Log::info('APP ID : ' . $app_id);

            if (isset($data['contacts'])) {

                $profile_name = isset($data['contacts'][0]['profile']['name']) ? $data['contacts'][0]['profile']['name'] : '';
            } else {

                $profile_name = "";
            }
//        $message_id = isset($events[0]['properties']['message_id']) ? $events[0]['properties']['message_id'] : 'n/a';

            Log::info('MESSAGE ID : ' . $message_id);

//        $message_name = isset($events[0]['name']) ? $events[0]['name'] : 'n/a';
//
//        Log::info('MESSAGE NAME : ' . $message_name);

            $stack_id = isset($events[0]['properties']['stack_id']) ? $events[0]['properties']['stack_id'] : 'n/a';

            Log::info('STACK ID : ' . $stack_id);

            $conversation_id = isset($events[0]['properties']['conversation_id']) ? $events[0]['properties']['conversation_id'] : 'n/a';

            Log::info('CONVERSATION ID : ' . $conversation_id);

            $message_type = isset($events[0]['properties']['type']) ? $events[0]['properties']['type'] : 'n/a';

            Log::info('Message Type : ' . $message_type);

//        $message_from = isset($device['mdn']) ? $device['mdn'] : 'n/a';


            Log::info('FROM : ' . $message_from);

            $message_timestamp = isset($events[0]['timestamp']) ? $events[0]['timestamp'] : 'n/a';

            Log::info('Message Timestamp : ' . $message_timestamp);

            $message_property_id = isset($events[0]['id']) ? $events[0]['id'] : 'n/a';

            Log::info('Message Property Id : ' . $message_property_id);

//        dd($message_timestamp);

//        if($message_type == 'text'){

//        $message_body = isset($events[0]['properties']['content']['body']) ? $events[0]['properties']['content']['body'] : null;


            $request['Body'] = $message_body;

            Log::info('Message Body : ' . $message_body);

//        }

            if ($message_body == null && $message_name != 'd360_whatsapp_message_in') {

                return 'ok';
            }

//        if($message_name == 'd360_whatsapp_message_in'){
//
//            $unique_message = new UniqueWhatsappMessage();
//
//            $unique_message->message_id = $message_id;
//
//            $unique_message->save();
//        }

            if ($message_name == 'text') {

                $unique_message = new UniqueWhatsappMessage();

                $unique_message->message_id = $message_id;

                $unique_message->save();
            }

            if ($message_name == 'interactive') {

                Log::info('kaaaaaaaaaaaaput');

                $interactive = $first_message['interactive'];

//            Log::info('Interactive : '.$interactive);

                if ($interactive['type'] == 'list_reply') {

                    $button_reply = $interactive['list_reply'];

                    $button_reply_id = $button_reply['id'];

                    Log::info('BRID : ' . $button_reply_id);

                    $button_reply_title = $button_reply['title'];

                    Log::info('BRT : ' . $button_reply_title);

                    $message_body = $button_reply_id;
                }

                if ($interactive['type'] == 'button_reply') {

                    $button_reply = $interactive['button_reply'];

                    $button_reply_id = $button_reply['id'];

                    Log::info('BRID : ' . $button_reply_id);

                    $button_reply_title = $button_reply['title'];

                    Log::info('BRT : ' . $button_reply_title);

                    $message_body = $button_reply_id;
                }
//            return 'ok';
            }


            $from = '+' . $message_from;

            // We truncate the WhatsApp number from the 13th character
            $truncated_number = substr($from, 4);

            // We create the number starting with 0
            $phone_number = '0' . $truncated_number;

            Log::info('FROM WHATSAPP NUMBER : ' . $from);

            $body = $string = preg_replace('/\s+/', '', $message_body);

            $media_url0 = null;

            Log::info('MEDIA0 : ' . $media_url0);

            $whatsapp_number = $from;

            Log::info('Body : ' . $body);

//        Log::info('Emoji : '. Emoji::Encode($body));

            $channel = 'WA'; //$request->channel;
            $user_identifier = $whatsapp_number;
            $message = $body;

//            if ($user_identifier != '254712675071') {
//
//                $whatsAppServiceApi->send('text', $message_from, 'We are currently upgrading this system, please try again later.', 'individual', false);
//
//                return 'ok';
//
//            }
        }

        $this->startEngine($botAccountsService,
            $user_identifier,
            $channel,
            $botSessionService,
            $message,
            $whatsappSessionRepository,
            $botSessionRepository,
            $botServices,
            $whatsAppServiceApi,
            $message_from,
            $message_body,
            $profile_name
        );
    }

    public function startEngine(BotAccountsService $botAccountsService,
                                $user_identifier,
                                $channel,
                                BotSessionService $botSessionService,
                                $message,
                                WhatsappSessionRepository $whatsappSessionRepository,
                                BotSessionRepository $botSessionRepository,
                                BotServices $botServices,
                                WhatsAppServiceApi $whatsAppServiceApi,
                                $message_from,
                                $raw_body,
                                $profile_name)
    {

        // Get Account From Channel and userIdentifier
        $bot_account = $botAccountsService->getAccount($user_identifier,
            $channel,
            new WhatsappAccountRepository(),
            new TelegramAccountRepository(),
            new MessengerAccountRepository());


        if (!is_null($bot_account)) {

            if ($message == 'aar') {

                if (BotConversation::where('bot_account_id', $bot_account->id)->where('channel', $channel)->exists()) {

                    Log::info('HIT BOT CONVO DEACTIVATE');

                    $bot_conversation = BotConversation::where('bot_account_id', $bot_account->id)->where('channel', $channel)->first();

                    $bot_conversation->conversation_status = 'inactive';

                    $bot_conversation->save();
                }
            }

            // check if session keyword
            if ($botSessionService->checkIfSessionExistsByName($channel, $message, new BotSessionRepository())) {

                Log::info('uid' . $user_identifier);

                $botSessionService->deactivateBotSession($channel,
                    $user_identifier,
                    $whatsappSessionRepository,
                    new TelegramSessionRepository(),
                    new MessengerSessionRepository());

//                $whatsappSessionRepository->deactivateWhatsAppSession($user_identifier);

                $bot_responses = $this->getSession($botSessionService, $user_identifier, $channel, $bot_account, $message);

                $reply_message = $bot_responses['bot_step']->step_title;

                $word = "profilename";
                $mystring = $bot_responses['bot_step']->step_title;

                // Test if string contains the word
                if (strpos($mystring, $word) !== false) {
                    Log::info("Word Found: " . $mystring);
                    $reply_message = str_replace("profilename", $profile_name, $mystring);
                    Log::info("Replaced reply message: " . $reply_message);
                }

                foreach ($bot_responses['bot_responses'] as $bot_response) {

                    $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
                }

                if ($channel == env('WHATSAPP_CHANNEL')) {

                    if (env('WA_BOT_ENV') == 'TWILIO') {
                        // TWILIO API CREDENTIALS
                        $sid = env('TWILIO_SID');
                        $token = env('TWILIO_TOKEN');

                        // The TujengePay WhatsApp number
                        $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                        // Initialize the Twilio Client
                        $twilio = new \Twilio\Rest\Client($sid, $token);

                        $message = $twilio->messages
                            ->create("whatsapp:" . $user_identifier,
                                array(
                                    "body" => $reply_message,
                                    "from" => "whatsapp:" . $whatsapp_live_number
                                )
                            );
                    }

                    if (env('WA_BOT_ENV') == '360') {


//                        $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);

                        foreach ($bot_responses['bot_responses'] as $bot_response) {

                            $rows[] = [
                                "id" => $bot_response->key_word,
                                "title" => $bot_response->response_text,
//                                "description" => $bot_response->response_text,
                            ];
                        }

                        $word = "profilename";
                        $mystring = $bot_responses['bot_step']->step_title;

                        // Test if string contains the word
                        if (strpos($mystring, $word) !== false) {
                            Log::info("Word Found: " . $mystring);
                            $body_text = str_replace("profilename", "*" . $profile_name . "*", $mystring);
                            Log::info("Replaced reply message: " . $reply_message);
                        }

                        $client = new \GuzzleHttp\Client();

                        $response = $client->request('POST', 'https://waba.360dialog.io/v1/messages', [
                            'headers' => [
                                'Content-Type' => 'application/json',
                                'D360-API-KEY' => 'BFA39DlBEFUc5Es07sVHpgqUAK',

                            ],

                            'body' => json_encode([
                                "recipient_type" => "individual",
                                "to" => $message_from,
                                "type" => "interactive",
                                "interactive" => [
                                    "type" => "list",
//                    "header" => [
//                        "type" => "text",
//                        "text" => "KPCL TOKENS HEADER"
//                    ],
                                    "body" => [
                                        "text" => $body_text
                                    ],
//                    "footer" => [
//                        "text" => "KPLC TOKENS FOOTER"
//                    ],
                                    "action" => [
                                        "button" => "Get Started",
                                        "sections" => [
                                            [
                                                "title" => "get-started",
                                                "rows" => $rows
                                            ],
//                            [
//                                "title" => "your-section",
//                                "rows" => [
//                                    [
//                                        "id" => "un2",
//                                        "title" => "row-title-content",
//                                        "description" => "row-description-content",
//                                    ]
//                                ]
//                            ],
                                        ]
                                    ]
                                ]])
                        ]);

                    }
                }

                if ($channel == env('TELEGRAM_CHANNEL')) {

                    $telegram = new Api(env('TELEGRAM_TOKEN'));

                    $keyboard = [
                        ['1. My cover'],
                        ['2. Benefit balances'],
                        ['3. Cover utilization'],
                        ['4. Claims'],
                        ['5. Pay'],
                        ['6. Premium statement'],
                        ['7. Request for quote'],
                        ['8. Request for letters'],
                        ['9. Buy insurance product'],
                        ['10. Customer care']
                    ];

                    $reply_markup = $telegram->replyKeyboardMarkup([
                        'keyboard' => $keyboard,
                        'resize_keyboard' => true,
                        'one_time_keyboard' => true
                    ]);

                    $response = $telegram->sendMessage([
                        'chat_id' => $user_identifier,
                        'text' => "Hi, Welcome to AAR Kenya Insurance chatbot. Get all your questions answered here quick and fast\nPlease choose an option below to start",
                        'reply_markup' => $reply_markup,
                        'parse_mode' => 'markdown'
                    ]);

                    $messageId = $response->getMessageId();

                }

                if ($channel == env('MESSENGER_CHANNEL')) {

                    Log::info('MESSENGER2');

                    //API Url and Access Token, generate this token value on your Facebook App Page
                    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                    $client = new \GuzzleHttp\Client();

                    $response = $client->request('POST', $url, [

                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],

                        'body' => json_encode([
                            'recipient' => [
                                'id' => $user_identifier,
                            ],
                            'messaging_type' => 'RESPONSE',
                            'message' => [
                                'text' => 'Pick an item below',
                                'quick_replies' => [
                                    [
                                        'content_type' => 'text',
                                        'title' => 'My cover',
                                        'payload' => '1',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Benefit balances',
                                        'payload' => '2',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Cover utilization',
                                        'payload' => '3',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Claims',
                                        'payload' => '4',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Pay',
                                        'payload' => '5',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Premium statement',
                                        'payload' => '6',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Request for quote',
                                        'payload' => '7',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Request for letters',
                                        'payload' => '8',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Buy insurance product',
                                        'payload' => '9',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Customer care',
                                        'payload' => '10',
                                    ]
                                ],
                            ],
                        ])
                    ]);

                }

                return 'ok';
            }

            //check if we have an active session

            // if we have an active session, we check for the responses that have the keyword in that bot session for the channel,
            // we update the whatsapp session step, we then deactivate the previous step and return the
            // json response

            $active_session = $botSessionService->checkForActiveSession($bot_account,
                $channel,
                new WhatsappSessionRepository(),
                new TelegramSessionRepository(),
                new MessengerSessionRepository());

            Log::info('AS');

            if ($active_session) {

                Log::info('SESSION ACTIVE');

                Log::info('AS1');

                $active_session_step = $botSessionService->getActiveBotStep($bot_account,
                    $channel,
                    new WhatsappSessionRepository(),
                    new TelegramSessionRepository(),
                    new MessengerSessionRepository());

                $session = $botSessionService->getActiveSession($channel,
                    $user_identifier,
                    new WhatsappSessionRepository(),
                    new TelegramSessionRepository(),
                    new MessengerSessionRepository());


                if ($session->bot_session->session_name == 'customer') {

                    $botServices->replyCustomerCare($user_identifier, $raw_body, 'handle_customer_care', env('WHATSAPP_CHANNEL'));


                    if (BotConversation::where('bot_account_id', $bot_account->id)->exists()) {

                        if (BotConversation::where('bot_account_id', $bot_account->id)->first()->conversation_status == 'inactive') {

                            $reply_message = "Hello 👋🏽. You are now chatting with a live customer care agent.\n\nPlease type your message below and we will assist you.\n\nTo exit this live chat, reply with the word *AAR*.";

                            if (BotConversation::where('bot_account_id', $bot_account->id)->where('channel', $channel)->exists()) {

                                Log::info('HIT BOT CONVO ACTIVATE');

                                $bot_conversation = BotConversation::where('bot_account_id', $bot_account->id)->where('channel', $channel)->first();

                                $bot_conversation->conversation_status = 'active';

                                $bot_conversation->save();
                            }

                        } else {

                            $customer_care = new CustomerCare();

                            $customer_care->notify(new SendCustomerMessageNotification($raw_body, $user_identifier, $profile_name));

                            $reply_message = "Message sent✅, to exit this live chat, reply with the word *AAR*.";
                        }
                    }

                    if($active_session_step->bot_session_step->is_initial_step && $message == 1){

                        $reply_message = "Please reply with your preferred time for a callback e.g Monday 6:30pm\n\n";
                    }

                    if($active_session_step->bot_session_step->is_initial_step && $message == 2){

                        $reply_message = "Please type in your message below and one of customer care agent will get back to you shortly\n\n";
                    }


                    if ($channel == env('WHATSAPP_CHANNEL')) {

                        if (env('WA_BOT_ENV') == 'TWILIO') {
                            // TWILIO API CREDENTIALS
                            $sid = env('TWILIO_SID');
                            $token = env('TWILIO_TOKEN');

                            // The TujengePay WhatsApp number
                            $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                            // Initialize the Twilio Client
                            $twilio = new \Twilio\Rest\Client($sid, $token);

                            $message = $twilio->messages
                                ->create("whatsapp:" . $user_identifier,
                                    array(
                                        "body" => $reply_message,
                                        "from" => "whatsapp:" . $whatsapp_live_number
                                    )
                                );
                        }

                        if (env('WA_BOT_ENV') == '360') {


                            $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                        }
                    }

                    if ($channel == env('TELEGRAM_CHANNEL')) {

                        $telegram = new Api(env('TELEGRAM_TOKEN'));

                        $response = $telegram->sendMessage([
                            'chat_id' => $user_identifier,
                            'text' => $reply_message,
                            'parse_mode' => 'markdown'
                        ]);
                    }

                }

                Log::info('res exists');

                $bot_session = $session->bot_session;

                Log::info('ASST ID ' . $active_session_step->id);

                if ($active_session_step->bot_session_step->is_initial_step && $bot_session->session_key_word == 0) {

                    $next_bot_session = $botSessionService->getNextBotSession($channel, $message, new BotSessionRepository());

                    if ($next_bot_session != false) {


                        $session = $botSessionService->processSession($user_identifier,
                            $channel,
                            $bot_account,
                            $next_bot_session,
                            new WhatsappSessionRepository(),
                            new TelegramSessionRepository(),
                            new MessengerSessionRepository());

                        $bot_session = $next_bot_session;

                        Log::info('NBS' . $next_bot_session->session_key_word);

                        $next_bot_step = $botSessionService->getZeroBotSessionStep($channel, $next_bot_session, new BotSessionRepository());

                        Log::info('NS' . $next_bot_step->session_step_key);
                    } else {

                        $bot_responses = $this->getStartSession($botSessionService, $user_identifier, $channel, $bot_account, $message);

                        $reply_message = $bot_responses['bot_step']->step_title;

                        $word = "profilename";
                        $mystring = $bot_responses['bot_step']->step_title;

                        // Test if string contains the word
                        if (strpos($mystring, $word) !== false) {
                            Log::info("Word Found: " . $mystring);
                            $reply_message = str_replace("profilename", $profile_name, $mystring);
                            Log::info("Replaced reply message: " . $reply_message);
                        }

                        foreach ($bot_responses['bot_responses'] as $bot_response) {

                            $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
                        }

                        $message_type = 'inline_buttons';

                        $body_text = "Hi ".$profile_name." 👋🏽"."Sorry I didn't understand what you said. I'm just a chatbot 😅...Please choose an option below to talk to a real person or to view *AAR* services.👇🏽";

                        if ($channel == env('WHATSAPP_CHANNEL')) {

                            if (env('WA_BOT_ENV') == '360') {

                                if ($message_type == 'inline_buttons') {

                                    $buttons = [
                                        [
                                            "type" => "reply",
                                            "reply" => [
                                                "id" => "customer",
                                                "title" => "Talk to a person"
                                            ]
                                        ],
                                        [
                                            "type" => "reply",
                                            "reply" => [
                                                "id" => "aar",
                                                "title" => "View AAR services"
                                            ]
                                        ]
                                    ];

                                    $whatsAppServiceApi->sendInteractiveButton($message_from, $buttons, $body_text);
                                }
                            }
                        }

                        if ($channel == env('TELEGRAM_CHANNEL')) {

                            $telegram = new Api(env('TELEGRAM_TOKEN'));

                            $keyboard = [
                                ['1. My cover'],
                                ['2. Benefit balances'],
                                ['3. Cover utilization'],
                                ['4. Claims'],
                                ['5. Pay'],
                                ['6. Premium statement'],
                                ['7. Request for quote'],
                                ['8. Request for letters'],
                                ['9. Buy insurance product'],
                                ['10. Customer care']
                            ];

                            $reply_markup = $telegram->replyKeyboardMarkup([
                                'keyboard' => $keyboard,
                                'resize_keyboard' => true,
                                'one_time_keyboard' => true
                            ]);

                            $response = $telegram->sendMessage([
                                'chat_id' => $user_identifier,
                                'text' => "Hi, Welcome to AAR Kenya Insurance chatbot. Get all your questions answered here quick and fast\nPlease choose an option below to start",
                                'reply_markup' => $reply_markup
                            ]);

                            $messageId = $response->getMessageId();

                        }

                        if ($channel == env('MESSENGER_CHANNEL')) {

                            Log::info('MESSENGER8');

                            //API Url and Access Token, generate this token value on your Facebook App Page
                            $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                            $client = new \GuzzleHttp\Client();

                            $response = $client->request('POST', $url, [
                                'headers' => [
                                    'Content-Type' => 'application/json',
                                ],
                                'body' => json_encode([
                                    'recipient' => [
                                        'id' => $user_identifier,
                                    ],
                                    'messaging_type' => 'RESPONSE',
                                    'message' => [
                                        'text' => 'Pick an item below',
                                        'quick_replies' => [
                                            [
                                                'content_type' => 'text',
                                                'title' => 'My cover',
                                                'payload' => '1',
                                            ],
                                            [
                                                'content_type' => 'text',
                                                'title' => 'Benefit balances',
                                                'payload' => '2',
                                            ],
                                            [
                                                'content_type' => 'text',
                                                'title' => 'Cover utilization',
                                                'payload' => '3',
                                            ],
                                            [
                                                'content_type' => 'text',
                                                'title' => 'Claims',
                                                'payload' => '4',
                                            ],
                                            [
                                                'content_type' => 'text',
                                                'title' => 'Pay',
                                                'payload' => '5',
                                            ],
                                            [
                                                'content_type' => 'text',
                                                'title' => 'Premium statement',
                                                'payload' => '6',
                                            ],
                                            [
                                                'content_type' => 'text',
                                                'title' => 'Request for quote',
                                                'payload' => '7',
                                            ],
                                            [
                                                'content_type' => 'text',
                                                'title' => 'Request for letters',
                                                'payload' => '8',
                                            ],
                                            [
                                                'content_type' => 'text',
                                                'title' => 'Buy insurance product',
                                                'payload' => '9',
                                            ],
                                            [
                                                'content_type' => 'text',
                                                'title' => 'Customer care',
                                                'payload' => '10',
                                            ]
                                        ],
                                    ],
                                ])
                            ]);
                        }

                        return 'ok';
                    }
                } else {

                    $next_bot_step = $botSessionService->getNextBotStep($channel, $active_session_step->bot_session_step, $message);
                }

                if ($next_bot_step != false) {


                    if ($active_session_step->bot_session_step->service_methods != null) {

                        $service_methods = (array)json_decode($active_session_step->bot_session_step->service_methods);

                        foreach ($service_methods as $service_method) {

                            if ($service_method->method_type == 'validate') {
                                $validation_results = $botServices->{$service_method->method_name}($message);

                                if ($validation_results == false) {

                                    $reply_message = 'You have entered an invalid input, please try again';

                                    if ($channel == env('WHATSAPP_CHANNEL')) {

                                        if (env('WA_BOT_ENV') == 'TWILIO') {
                                            // TWILIO API CREDENTIALS
                                            $sid = env('TWILIO_SID');
                                            $token = env('TWILIO_TOKEN');

                                            // The TujengePay WhatsApp number
                                            $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                            // Initialize the Twilio Client
                                            $twilio = new \Twilio\Rest\Client($sid, $token);

                                            $message = $twilio->messages
                                                ->create("whatsapp:" . $user_identifier,
                                                    array(
                                                        "body" => $reply_message,
                                                        "from" => "whatsapp:" . $whatsapp_live_number
                                                    )
                                                );
                                        }

                                        if (env('WA_BOT_ENV') == '360') {


                                            $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                                        }
                                    }

                                    if ($channel == env('TELEGRAM_CHANNEL')) {

                                        $telegram = new Api(env('TELEGRAM_TOKEN'));

                                        $response = $telegram->sendMessage([
                                            'chat_id' => $user_identifier,
                                            'text' => $reply_message,
                                            'parse_mode' => 'markdown'
                                        ]);
                                    }

                                    if ($channel == env('MESSENGER_CHANNEL')) {

                                        Log::info('MESSENGER3');


                                        //API Url and Access Token, generate this token value on your Facebook App Page
                                        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                                        $client = new \GuzzleHttp\Client();

                                        $response = $client->request('POST', $url, [
                                            'timeout' => 45, // Response timeout
                                            'connect_timeout' => 30, // Connection timeout
                                            'headers' => [
                                                'Content-Type' => 'application/json',
                                            ],
                                            'body' => json_encode([
                                                'recipient' => [
                                                    'id' => $user_identifier
                                                ],
                                                'message' => [
                                                    'text' => $reply_message
                                                ]
                                            ])
                                        ]);
                                    }

                                    return 'ok';
                                }
                                // Save a whatsapp number policy
                            }

                            if ($service_method->method_type == 'send_otp') {

                                Log::info('MT : OTP');

                                $botServices->{$service_method->method_name}($user_identifier);
                            }

                            if ($service_method->method_type == 'update_membership_no') {

                                Log::info('UPDATE MNO');

                                $botServices->{$service_method->method_name}($user_identifier, $message, $channel);
                            }

                            if ($service_method->method_type == 'confirm_otp') {

                                Log::info('Confirm : OTP');

                                $opt_confirmation_status = $botServices->{$service_method->method_name}($user_identifier, $message, $channel);

                                if ($opt_confirmation_status == false) {

                                    $reply_message = 'You have entered an invalid OTP, please try again';

                                    if ($channel == env('WHATSAPP_CHANNEL')) {

                                        if (env('WA_BOT_ENV') == 'TWILIO') {
                                            // TWILIO API CREDENTIALS
                                            $sid = env('TWILIO_SID');
                                            $token = env('TWILIO_TOKEN');

                                            // The TujengePay WhatsApp number
                                            $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                            // Initialize the Twilio Client
                                            $twilio = new \Twilio\Rest\Client($sid, $token);

                                            $message = $twilio->messages
                                                ->create("whatsapp:" . $user_identifier,
                                                    array(
                                                        "body" => $reply_message,
                                                        "from" => "whatsapp:" . $whatsapp_live_number
                                                    )
                                                );
                                        }

                                        if (env('WA_BOT_ENV') == '360') {


                                            $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                                        }
                                    }

                                    if ($channel == env('TELEGRAM_CHANNEL')) {

                                        $telegram = new Api(env('TELEGRAM_TOKEN'));

                                        $response = $telegram->sendMessage([
                                            'chat_id' => $user_identifier,
                                            'text' => $reply_message,
                                            'parse_mode' => 'markdown'
                                        ]);
                                    }

                                    if ($channel == env('MESSENGER_CHANNEL')) {

                                        Log::info('MESSENGER4');

                                        //API Url and Access Token, generate this token value on your Facebook App Page
                                        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                                        $client = new \GuzzleHttp\Client();

                                        $response = $client->request('POST', $url, [
                                            'timeout' => 45, // Response timeout
                                            'connect_timeout' => 30, // Connection timeout
                                            'headers' => [
                                                'Content-Type' => 'application/json',
                                            ],
                                            'body' => json_encode([
                                                'recipient' => [
                                                    'id' => $user_identifier
                                                ],
                                                'message' => [
                                                    'text' => $reply_message
                                                ]
                                            ])
                                        ]);
                                    }

//                                    return 'ok';
                                }
                            }

                            if ($service_method->method_type == 'query_balance') {

                                Log::info('QUERY BALANCE');

                                $reply_message = $botServices->{$service_method->method_name}($user_identifier, $channel, 'query_balance');

                                if ($channel == env('WHATSAPP_CHANNEL')) {

                                    if (env('WA_BOT_ENV') == 'TWILIO') {
                                        // TWILIO API CREDENTIALS
                                        $sid = env('TWILIO_SID');
                                        $token = env('TWILIO_TOKEN');

                                        // The TujengePay WhatsApp number
                                        $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                        // Initialize the Twilio Client
                                        $twilio = new \Twilio\Rest\Client($sid, $token);

                                        $message = $twilio->messages
                                            ->create("whatsapp:" . $user_identifier,
                                                array(
                                                    "body" => $reply_message,
                                                    "from" => "whatsapp:" . $whatsapp_live_number
                                                )
                                            );
                                    }

                                    if (env('WA_BOT_ENV') == '360') {


                                        $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                                    }
                                }

                                if ($channel == env('TELEGRAM_CHANNEL')) {

                                    $telegram = new Api(env('TELEGRAM_TOKEN'));

                                    $response = $telegram->sendMessage([
                                        'chat_id' => $user_identifier,
                                        'text' => $reply_message,
                                        'parse_mode' => 'markdown'
                                    ]);
                                }

                                if ($channel == env('MESSENGER_CHANNEL')) {

                                    Log::info('MESSENGER5');


                                    //API Url and Access Token, generate this token value on your Facebook App Page
                                    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                                    $client = new \GuzzleHttp\Client();

                                    $response = $client->request('POST', $url, [
                                        'timeout' => 45, // Response timeout
                                        'connect_timeout' => 30, // Connection timeout
                                        'headers' => [
                                            'Content-Type' => 'application/json',
                                        ],
                                        'body' => json_encode([
                                            'recipient' => [
                                                'id' => $user_identifier
                                            ],
                                            'message' => [
                                                'text' => $reply_message
                                            ]
                                        ])
                                    ]);
                                }

//                                return 'ok';
                            }

                            if ($service_method->method_type == 'query_cover') {

                                Log::info('QUERY COVER');

                                $reply_message = $botServices->{$service_method->method_name}($user_identifier, $channel, 'query_cover');

                                if ($channel == env('WHATSAPP_CHANNEL')) {

                                    if (env('WA_BOT_ENV') == 'TWILIO') {
                                        // TWILIO API CREDENTIALS
                                        $sid = env('TWILIO_SID');
                                        $token = env('TWILIO_TOKEN');

                                        // The TujengePay WhatsApp number
                                        $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                        // Initialize the Twilio Client
                                        $twilio = new \Twilio\Rest\Client($sid, $token);

                                        $message = $twilio->messages
                                            ->create("whatsapp:" . $user_identifier,
                                                array(
                                                    "body" => $reply_message,
                                                    "from" => "whatsapp:" . $whatsapp_live_number
                                                )
                                            );
                                    }

                                    if (env('WA_BOT_ENV') == '360') {


                                        $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                                    }
                                }

                                if ($channel == env('TELEGRAM_CHANNEL')) {

                                    $telegram = new Api(env('TELEGRAM_TOKEN'));

                                    $response = $telegram->sendMessage([
                                        'chat_id' => $user_identifier,
                                        'text' => $reply_message,
                                        'parse_mode' => 'markdown'
                                    ]);
                                }

                                if ($channel == env('MESSENGER_CHANNEL')) {

                                    Log::info('MESSENGER5');


                                    //API Url and Access Token, generate this token value on your Facebook App Page
                                    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                                    $client = new \GuzzleHttp\Client();

                                    $response = $client->request('POST', $url, [
                                        'timeout' => 45, // Response timeout
                                        'connect_timeout' => 30, // Connection timeout
                                        'headers' => [
                                            'Content-Type' => 'application/json',
                                        ],
                                        'body' => json_encode([
                                            'recipient' => [
                                                'id' => $user_identifier
                                            ],
                                            'message' => [
                                                'text' => $reply_message
                                            ]
                                        ])
                                    ]);
                                }

                                return 'ok';
                            }

                            if ($service_method->method_type == 'query_utilization') {

                                Log::info('QUERY UTILIZATION');

                                $reply_message = $botServices->{$service_method->method_name}($user_identifier, $channel, 'query_utilization');

                                if ($channel == env('WHATSAPP_CHANNEL')) {

                                    if (env('WA_BOT_ENV') == 'TWILIO') {
                                        // TWILIO API CREDENTIALS
                                        $sid = env('TWILIO_SID');
                                        $token = env('TWILIO_TOKEN');

                                        // The TujengePay WhatsApp number
                                        $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                        // Initialize the Twilio Client
                                        $twilio = new \Twilio\Rest\Client($sid, $token);

                                        $message = $twilio->messages
                                            ->create("whatsapp:" . $user_identifier,
                                                array(
                                                    "body" => $reply_message,
                                                    "from" => "whatsapp:" . $whatsapp_live_number
                                                )
                                            );
                                    }

                                    if (env('WA_BOT_ENV') == '360') {


                                        $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                                    }
                                }

                                if ($channel == env('TELEGRAM_CHANNEL')) {

                                    $telegram = new Api(env('TELEGRAM_TOKEN'));

                                    $response = $telegram->sendMessage([
                                        'chat_id' => $user_identifier,
                                        'text' => $reply_message,
                                        'parse_mode' => 'markdown'
                                    ]);
                                }

                                if ($channel == env('MESSENGER_CHANNEL')) {

                                    Log::info('MESSENGER5');


                                    //API Url and Access Token, generate this token value on your Facebook App Page
                                    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                                    $client = new \GuzzleHttp\Client();

                                    $response = $client->request('POST', $url, [
                                        'timeout' => 45, // Response timeout
                                        'connect_timeout' => 30, // Connection timeout
                                        'headers' => [
                                            'Content-Type' => 'application/json',
                                        ],
                                        'body' => json_encode([
                                            'recipient' => [
                                                'id' => $user_identifier
                                            ],
                                            'message' => [
                                                'text' => $reply_message
                                            ]
                                        ])
                                    ]);
                                }

//                                return 'ok';
                            }

                            if ($service_method->method_type == 'save_quote') {

                                Log::info('SAVE QUOTE');

                                $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'save_quote');

                            }

                            if ($service_method->method_type == 'save_quote_email') {

                                Log::info('SAVE QUOTE EMAIL');

                                $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'save_quote_email');
                            }

                            if ($service_method->method_type == 'save_quote_cover_type') {

                                Log::info('SAVE QUOTE COVER TYPE');

                                $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'save_quote_cover_type');
                            }

                            if ($service_method->method_type == 'save_quote_first_name') {

                                Log::info('SAVE QUOTE FIRST NAME');

                                $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'save_quote_first_name');
                            }

                            if ($service_method->method_type == 'save_quote_second_name') {

                                Log::info('SAVE QUOTE SECOND NAME');

                                $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'save_quote_second_name');
                            }

                            if ($service_method->method_type == 'save_quote_second_name') {

                                Log::info('SAVE QUOTE SECOND NAME');

                                $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'save_quote_second_name');
                            }

                            if ($service_method->method_type == 'save_quote_last_name') {

                                Log::info('SAVE QUOTE LAST NAME');

                                $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'save_quote_last_name');
                            }

                            if ($service_method->method_type == 'save_quote_age_bracket') {

                                Log::info('SAVE QUOTE AGE BRACKET');

                                $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'save_quote_age_bracket');
                            }

                            if ($service_method->method_type == 'save_quote_gender') {

                                Log::info('SAVE QUOTE GENDER');

                                $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'save_quote_gender');
                            }

                            if ($service_method->method_type == 'save_quote_out_patient') {

                                Log::info('SAVE QUOTE OUT PATIENT');

                                $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'save_quote_out_patient');
                            }

                            if ($service_method->method_type == 'save_quote_out_patient_rate') {

                                Log::info('SAVE QUOTE OUT PATIENT RATE');

                                $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'save_quote_out_patient_rate');
                            }

                            if ($service_method->method_type == 'save_quote_inpatient') {

                                Log::info('SAVE QUOTE OUT INPATIENT');

                                $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'save_quote_inpatient');
                            }

                            if ($service_method->method_type == 'close_quote') {

                                Log::info('CLOSE QUOTE');

                                $reply_message = $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'close_quote');

                                Log::info('mes' . $reply_message);

                                if ($reply_message != false) {

                                    if ($channel == env('WHATSAPP_CHANNEL')) {

                                        if (env('WA_BOT_ENV') == 'TWILIO') {
                                            // TWILIO API CREDENTIALS
                                            $sid = env('TWILIO_SID');
                                            $token = env('TWILIO_TOKEN');

                                            // The TujengePay WhatsApp number
                                            $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                            // Initialize the Twilio Client
                                            $twilio = new \Twilio\Rest\Client($sid, $token);

                                            $message = $twilio->messages
                                                ->create("whatsapp:" . $user_identifier,
                                                    array(
                                                        "body" => $reply_message,
                                                        "from" => "whatsapp:" . $whatsapp_live_number
                                                    )
                                                );
                                        }

                                        if (env('WA_BOT_ENV') == '360') {


                                            $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                                        }
                                    }

                                    if ($channel == env('TELEGRAM_CHANNEL')) {

                                        $telegram = new Api(env('TELEGRAM_TOKEN'));

                                        $response = $telegram->sendMessage([
                                            'chat_id' => $user_identifier,
                                            'text' => $reply_message,
                                            'parse_mode' => 'markdown'
                                        ]);
                                    }

                                    if ($channel == env('MESSENGER_CHANNEL')) {

                                        Log::info('MESSENGER6');

                                        //API Url and Access Token, generate this token value on your Facebook App Page
                                        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                                        $client = new \GuzzleHttp\Client();

                                        $response = $client->request('POST', $url, [
                                            'timeout' => 45, // Response timeout
                                            'connect_timeout' => 30, // Connection timeout
                                            'headers' => [
                                                'Content-Type' => 'application/json',
                                            ],
                                            'body' => json_encode([
                                                'recipient' => [
                                                    'id' => $user_identifier
                                                ],
                                                'message' => [
                                                    'text' => $reply_message
                                                ]
                                            ])
                                        ]);
////Initiate cURL.
//                                    $ch = curl_init($url);
//
//
////The JSON data.
//                                    $jsonData = '{
//    "recipient":{
//        "id":"' . $user_identifier . '"
//    },
//    "message":{
//        "text": "'.$reply_message.'"
//    }
//}';
//
////Tell cURL that we want to send a POST request.
//                                    curl_setopt($ch, CURLOPT_POST, 1);
//
////Attach our encoded JSON string to the POST fields.
//                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
//
////Set the content type to application/json
//                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//
////Execute the request but first check if the message is not empty.
////                                    if (!empty($input['entry'][0]['messaging'][0]['message'])) {
//                                        $result = curl_exec($ch);
////                                    }
//
//
                                    }

                                    $botSessionService->deactivateBotSessionSteps($channel,
                                        $user_identifier,
                                        $bot_account,
                                        new WhatsappSessionRepository(),
                                        new TelegramSessionRepository(),
                                        new MessengerSessionRepository());

                                    $botSessionService->setSessionStep($session,
                                        $channel,
                                        $user_identifier,
                                        $message,
                                        $bot_account,
                                        $next_bot_step,
                                        new WhatsappSessionRepository(),
                                        new TelegramSessionRepository(),
                                        new MessengerSessionRepository());

                                    return 'ok';

                                }
                            }

                            if ($service_method->method_type == 'membership_check') {

                                if ($message == 10 || $message == 9 || $message == 7) {

                                } else {

                                    Log::info('CHECK USER MEMBERSHIP');

                                    $result = $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'membership_check');

                                    Log::info('RESULT INFO ' . $result);

                                    if ($result == true) {

                                        // check if an otp has been sent

                                        Log::info('MT : OTP');

                                        Log::info('NEXT BOT STEP ' . $next_bot_step);

                                        $next_bot_step = $botSessionService->getNextBotStep($channel, $next_bot_step, $message);

                                        if (WhatsappOtpCode::where('phone_number', $user_identifier)
                                            ->where('status', 'active')
                                            ->exists()) {
                                            $otp_code = WhatsappOtpCode::where('phone_number', $user_identifier)
                                                ->where('status', 'active')
                                                ->first();

                                            if (!Carbon::now()->lessThan($otp_code->expires_at)) {

                                                $botServices->sendOtp($user_identifier);
                                            } else {
                                                $next_bot_step = $botSessionService->getNextBotStep($channel, $next_bot_step, $message);
                                            }
                                        } else {
                                            $botServices->sendOtp($user_identifier);
                                        }
                                    }
                                }


                            }

                            if ($service_method->method_type == 'check_mpesa_number') {

                                Log::info('Check Mpesa Number');
                            }

                            if ($service_method->method_type == 'store_mpesa_number') {

                                Log::info('SAVE MPESA AMOUNT');

                                $result = $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'store_mpesa_number');

                            }

                            if ($service_method->method_type == 'payment_amount') {

                                Log::info('SAVE MPESA AMOUNT');

                                $result = $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'payment_amount');
                            }

                            if ($service_method->method_type == 'query_policy_statement') {

                                Log::info('QUERY POLICY STATEMENT');

                                $reply_message = $botServices->{$service_method->method_name}($user_identifier, $message, 'query_policy_statement', $channel);

//                                return 'ok';
                            }

                            if ($service_method->method_type == 'handle_customer_care') {

                                Log::info('HANDLE CUSTOMER CARE');

                                $reply_message = $botServices->{$service_method->method_name}($user_identifier, $message, 'handle_customer_care', $channel);

                                if ($reply_message != false) {

                                    if ($channel == env('WHATSAPP_CHANNEL')) {

                                        if (env('WA_BOT_ENV') == 'TWILIO') {
                                            // TWILIO API CREDENTIALS
                                            $sid = env('TWILIO_SID');
                                            $token = env('TWILIO_TOKEN');

                                            // The TujengePay WhatsApp number
                                            $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                            // Initialize the Twilio Client
                                            $twilio = new \Twilio\Rest\Client($sid, $token);

                                            $message = $twilio->messages
                                                ->create("whatsapp:" . $user_identifier,
                                                    array(
                                                        "body" => $reply_message,
                                                        "from" => "whatsapp:" . $whatsapp_live_number
                                                    )
                                                );
                                        }

                                        if (env('WA_BOT_ENV') == '360') {


                                            $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                                        }
                                    }

                                    if ($channel == env('TELEGRAM_CHANNEL')) {

                                        $telegram = new Api(env('TELEGRAM_TOKEN'));

                                        $response = $telegram->sendMessage([
                                            'chat_id' => $user_identifier,
                                            'text' => $reply_message,
                                            'parse_mode' => 'markdown'
                                        ]);
                                    }

                                    if ($channel == env('MESSENGER_CHANNEL')) {

                                        Log::info('MESSENGER6');

                                        //API Url and Access Token, generate this token value on your Facebook App Page
                                        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                                        $client = new \GuzzleHttp\Client();

                                        $response = $client->request('POST', $url, [
                                            'timeout' => 45, // Response timeout
                                            'connect_timeout' => 30, // Connection timeout
                                            'headers' => [
                                                'Content-Type' => 'application/json',
                                            ],
                                            'body' => json_encode([
                                                'recipient' => [
                                                    'id' => $user_identifier
                                                ],
                                                'message' => [
                                                    'text' => $reply_message
                                                ]
                                            ])
                                        ]);
                                    }
                                    return 'ok';
                                }
                                return 'ok';
                            }

                            if ($service_method->method_type == 'select_letter') {

                                Log::info('SELECT LETTER');

                                $reply_message = $botServices->{$service_method->method_name}($user_identifier, $message, 'select_letter', $channel);

                            }

                            if ($service_method->method_type == 'save_travel_date') {

                                Log::info('SAVE TRAVEL DATE');

                                $reply_message = $botServices->{$service_method->method_name}($user_identifier, $message, 'save_travel_date', $channel);

                            }

                            if ($service_method->method_type == 'save_return_date') {

                                Log::info('SAVE RETURN DATE');

                                $reply_message = $botServices->{$service_method->method_name}($user_identifier, $message, 'save_return_date', $channel);

                            }

                            if ($service_method->method_type == 'save_destination') {

                                Log::info('SAVE DESTINATION');

                                $reply_message = $botServices->{$service_method->method_name}($user_identifier, $message, 'save_destination', $channel);

                            }

                            if ($service_method->method_type == 'download_letter') {

                                Log::info('DOWNLOAD LETTER');

                                $reply_message = $botServices->{$service_method->method_name}($user_identifier, $message, 'download_letter', $channel);

                                if ($reply_message != false) {

                                    if ($channel == env('WHATSAPP_CHANNEL')) {

                                        if (env('WA_BOT_ENV') == 'TWILIO') {
                                            // TWILIO API CREDENTIALS
                                            $sid = env('TWILIO_SID');
                                            $token = env('TWILIO_TOKEN');

                                            // The TujengePay WhatsApp number
                                            $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                            // Initialize the Twilio Client
                                            $twilio = new \Twilio\Rest\Client($sid, $token);

                                            $message = $twilio->messages
                                                ->create("whatsapp:" . $user_identifier,
                                                    array(
                                                        "body" => $reply_message,
                                                        "from" => "whatsapp:" . $whatsapp_live_number
                                                    )
                                                );
                                        }

                                        if (env('WA_BOT_ENV') == '360') {

                                            $whatsAppServiceApi->sendFile('document', $message_from, 'Please download your letter below', 'individual', $reply_message);
                                        }
                                    }

                                    if ($channel == env('TELEGRAM_CHANNEL')) {

                                        $telegram = new Api(env('TELEGRAM_TOKEN'));

                                        $response = $telegram->sendDocument([
                                            'chat_id' => $user_identifier,
                                            'document' => $reply_message,
                                            'caption' => 'Please download your letter below',
//                                            'parse_mode' => 'markdown'
                                        ]);

                                        $messageId = $response->getMessageId();
                                    }

                                    if ($channel == env('MESSENGER_CHANNEL')) {

                                        Log::info('MESSENGER6');

                                        //API Url and Access Token, generate this token value on your Facebook App Page
                                        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                                        $client = new \GuzzleHttp\Client();

                                        $response = $client->request('POST', $url, [
                                            'timeout' => 45, // Response timeout
                                            'connect_timeout' => 30, // Connection timeout
                                            'headers' => [
                                                'Content-Type' => 'application/json',
                                            ],
                                            'body' => json_encode([
                                                'recipient' => [
                                                    'id' => $user_identifier,
                                                ],
                                                'message' => [
                                                    'attachment' => [
                                                        'type' => 'file',
                                                        'payload' => [
                                                            'url' => 'https://hcluster1.aar-insurance.com/storage/travel.pdf',
                                                            'is_reusable' => true,
                                                        ],
                                                    ],
                                                ]
                                            ])
                                        ]);
                                    }

                                    $botSessionService->deactivateBotSessionSteps($channel,
                                        $user_identifier,
                                        $bot_account,
                                        new WhatsappSessionRepository(),
                                        new TelegramSessionRepository(),
                                        new MessengerSessionRepository());

//                                    return 'ok';
                                }
                            }

                        }
                    }

                    $bot_responses = $botSessionService->getBotResponses($message, $channel, $bot_session, $next_bot_step);


                    $botSessionService->deactivateBotSessionSteps($channel,
                        $user_identifier,
                        $bot_account,
                        new WhatsappSessionRepository(),
                        new TelegramSessionRepository(),
                        new MessengerSessionRepository());

                    $botSessionService->setSessionStep($session,
                        $channel,
                        $user_identifier,
                        $message,
                        $bot_account,
                        $next_bot_step,
                        new WhatsappSessionRepository(),
                        new TelegramSessionRepository(),
                        new MessengerSessionRepository());


                    $word = "profilename";
                    $mystring = $next_bot_step->step_title;

                    // Test if string contains the word
                    if (strpos($mystring, $word) !== false) {
                        Log::info("Word Found: " . $mystring);
                        $reply_message = str_replace("profilename", $profile_name, $mystring);
                        Log::info("Replaced reply message: " . $reply_message);
                    }else{
                        $reply_message = $next_bot_step->step_title;
                    }

                    foreach ($bot_responses as $bot_response) {

                        $word = "profilename";
                        $mystring = $bot_response->response_text;

                        // Test if string contains the word
                        if (strpos($mystring, $word) !== false) {
                            Log::info("Word Found: " . $mystring);
                            $bot_response_text = str_replace("profilename", $profile_name, $mystring);
                            Log::info("Replaced reply message: " . $reply_message);
                        } else {

                            $bot_response_text = $bot_response->response_text;
                        }

                        $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response_text . "\n" : $bot_response_text . "\n";
                    }

                    if ($next_bot_step->response_source == 'function') {

                        if ($next_bot_step->response_function == 'queryPolicyStatement') {

                            Log::info('QUERY POLICY STATEMENT');

                            $reply_message = $botServices->{$next_bot_step->response_function}($user_identifier, $message, 'query_policy_statement', $channel);
                        } elseif ($next_bot_step->response_function == 'queryUtilization') {
                            $reply_message = $botServices->{$next_bot_step->response_function}($user_identifier, $channel, 'query_utilization');
                        } elseif ($next_bot_step->response_function == 'queryCover') {
                            $reply_message = $botServices->{$next_bot_step->response_function}($user_identifier, $channel, 'query_cover');
                        } elseif ($next_bot_step->response_function == 'queryBalances') {
                            $reply_message = $botServices->{$next_bot_step->response_function}($user_identifier, $channel, 'query_balance');
                        } else {

                            $reply_message = $botServices->{$next_bot_step->response_function}($user_identifier, $channel);
                        }

//                        return 'ok';
                    }

                    if ($channel == env('WHATSAPP_CHANNEL')) {

                        if (env('WA_BOT_ENV') == 'TWILIO') {
                            // TWILIO API CREDENTIALS
                            $sid = env('TWILIO_SID');
                            $token = env('TWILIO_TOKEN');

                            // The TujengePay WhatsApp number
                            $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                            // Initialize the Twilio Client
                            $twilio = new \Twilio\Rest\Client($sid, $token);

                            $message = $twilio->messages
                                ->create("whatsapp:" . $user_identifier,
                                    array(
                                        "body" => $reply_message,
                                        "from" => "whatsapp:" . $whatsapp_live_number
                                    )
                                );
                        }


                        if (env('WA_BOT_ENV') == '360') {

                            if ($next_bot_step->reply_type == 'inline_buttons') {

                                $word = "profilename";
                                $mystring = $next_bot_step->step_title;

                                // Test if string contains the word
                                if (strpos($mystring, $word) !== false) {
                                    Log::info("Word Found: " . $mystring);
                                    $next_bot_step_title = str_replace("profilename", $profile_name, $mystring);
                                    Log::info("Replaced reply message: " . $reply_message);
                                } else {

                                    $next_bot_step_title = $next_bot_step->step_title;
                                }

                                foreach ($bot_responses as $bot_response) {

                                    $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";

                                    $buttons[] = [
                                        "type" => "reply",
                                        "reply" => [
                                            "id" => $bot_response->key_word,
                                            "title" => $bot_response->response_text
                                        ]
                                    ];
                                }

                                $whatsAppServiceApi->sendInteractiveButton($message_from, $buttons, $next_bot_step->step_title == '' ? 'Pick an item below' : $next_bot_step_title);

                            } elseif ($next_bot_step->reply_type == 'list') {

                                $word = "profilename";
                                $mystring = $next_bot_step->step_title;

                                // Test if string contains the word
                                if (strpos($mystring, $word) !== false) {
                                    Log::info("Word Found: " . $mystring);
                                    $next_bot_step_title = str_replace("profilename", $profile_name, $mystring);
                                    Log::info("Replaced reply message: " . $reply_message);
                                } else {

                                    $next_bot_step_title = $next_bot_step->step_title;
                                }

                                $sections = [
                                    [
                                        "title" => 'Pick an item below',
                                        'rows' => []
                                    ]
                                ];

                                foreach ($bot_responses as $bot_response) {

                                    $sections[0]['rows'][] =

                                        [
                                            "id" => $bot_response->key_word,
                                            "title" => $bot_response->response_text
                                        ];
                                }

                                $whatsAppServiceApi->sendInteractiveList($message_from, $sections, $next_bot_step->step_title == '' ? 'Pick an item below' : $next_bot_step_title);

                            } else {

                                $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                            }
                        }
                    }

                    if ($channel == env('TELEGRAM_CHANNEL')) {

                        $telegram = new Api(env('TELEGRAM_TOKEN'));

                        if ($next_bot_step->reply_type == 'inline_keyboard') {

                            $key_boards = [];

                            foreach ($bot_responses as $bot_response) {

                                $key_boards[] = ['text' => $bot_response->response_text, 'callback_data' => $bot_response->key_word];
                            }

                            $keyboard = [
                                'inline_keyboard' => [
//                                [
////                                    ['text' => 'My cover', 'callback_data' => '/start'],
//                                ]
                                    $key_boards

                                ]
                            ];
                            $encodedKeyboard = json_encode($keyboard);

                            $response = $telegram->sendMessage([
                                'chat_id' => $user_identifier,
                                'text' => $next_bot_step->step_title == '' ? 'Select an option below' : $next_bot_step->step_title,
                                'reply_markup' => $encodedKeyboard,
                                'parse_mode' => 'markdown'
                            ]);

                        } elseif ($next_bot_step->reply_type == 'keyboard_buttons') {


                            foreach ($bot_responses as $bot_response) {

                                $key_boards[] = [$bot_response->key_word . ' ' . $bot_response->response_text];
                            }


                            $reply_markup = $telegram->replyKeyboardMarkup([
                                'keyboard' => $key_boards,
                                'resize_keyboard' => true,
                                'one_time_keyboard' => true
                            ]);

                            $response = $telegram->sendMessage([
                                'chat_id' => $user_identifier,
                                'text' => $next_bot_step->step_title == '' ? 'Select an item below' : $next_bot_step->step_title,
                                'reply_markup' => $reply_markup,
                                'parse_mode' => 'markdown'
                            ]);
                        } else {

                            $response = $telegram->sendMessage([
                                'chat_id' => $user_identifier,
                                'text' => $reply_message,
                                'parse_mode' => 'markdown'
                            ]);
                        }
                    }

                    if ($channel == env('MESSENGER_CHANNEL')) {

                        Log::info('MESSENGER7');

                        if ($next_bot_step->reply_type == 'quick_reply') {

                            foreach ($bot_responses as $bot_response) {

                                $quick_replies[] = [
                                    'content_type' => 'text',
                                    'title' => $bot_response->response_text,
                                    'payload' => $bot_response->key_word
                                ];
                            }

                            //API Url and Access Token, generate this token value on your Facebook App Page
                            $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                            $client = new \GuzzleHttp\Client();

                            $response = $client->request('POST', $url, [

                                'headers' => [
                                    'Content-Type' => 'application/json',
                                ],

                                'body' => json_encode([
                                    'recipient' => [
                                        'id' => $user_identifier,
                                    ],
                                    'messaging_type' => 'RESPONSE',
                                    'message' => [
                                        'text' => $next_bot_step->step_title == '' ? 'Select an item below' : $next_bot_step->step_title,
                                        'quick_replies' => $quick_replies
                                    ],
                                ])
                            ]);

                        } else {
                            //API Url and Access Token, generate this token value on your Facebook App Page
                            $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                            $client = new \GuzzleHttp\Client();

                            $response = $client->request('POST', $url, [
                                'timeout' => 45, // Response timeout
                                'connect_timeout' => 30, // Connection timeout
                                'headers' => [
                                    'Content-Type' => 'application/json',
                                ],
                                'body' => json_encode([
                                    'recipient' => [
                                        'id' => $user_identifier
                                    ],
                                    'message' => [
                                        'text' => $reply_message
                                    ]
                                ])
                            ]);
                        }


////Initiate cURL.
//                    $ch = curl_init($url);
//
//
////The JSON data.
//                    $jsonData = '{
//    "recipient":{
//        "id":"' . $user_identifier . '"
//    },
//    "message":{
//        "text": "'.$reply_message.'"
//    }
//}';
//
////Tell cURL that we want to send a POST request.
//                    curl_setopt($ch, CURLOPT_POST, 1);
//
////Attach our encoded JSON string to the POST fields.
//                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
//
////Set the content type to application/json
//                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//
////Execute the request but first check if the message is not empty.
////                    if (!empty($input['entry'][0]['messaging'][0]['message'])) {
//                        $result = curl_exec($ch);
////                    }


                    }

                } else {

                    $bot_responses = $this->getStartSession($botSessionService, $user_identifier, $channel, $bot_account, $message);

                    $reply_message = $bot_responses['bot_step']->step_title;

                    $word = "profilename";
                    $mystring = $bot_responses['bot_step']->step_title;

                    // Test if string contains the word
                    if (strpos($mystring, $word) !== false) {
                        Log::info("Word Found: " . $mystring);
                        $reply_message = str_replace("profilename", $profile_name, $mystring);
                        Log::info("Replaced reply message: " . $reply_message);
                    }

                    foreach ($bot_responses['bot_responses'] as $bot_response) {

                        $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
                    }

                    $message_type = 'inline_buttons';

                    $body_text = "Hi ".$profile_name." 👋🏽"."Sorry I didn't understand what you said. I'm just a chatbot 😅...Please choose an option below to talk to a real person or to view *AAR* services.👇🏽";

                    if ($channel == env('WHATSAPP_CHANNEL')) {

                        if (env('WA_BOT_ENV') == '360') {

                            if ($message_type == 'inline_buttons') {

                                $buttons[] = [
                                    [
                                        "type" => "reply",
                                        "reply" => [
                                            "id" => "customer",
                                            "title" => "Talk to a person"
                                        ]
                                    ],
                                    [
                                        "type" => "reply",
                                        "reply" => [
                                            "id" => "aar",
                                            "title" => "View AAR services"
                                        ]
                                    ]
                                ];

                                $whatsAppServiceApi->sendInteractiveButton($message_from, $buttons, $body_text);
                            }
                        }
                    }

//                    if ($channel == env('WHATSAPP_CHANNEL')) {
//
//                        if (env('WA_BOT_ENV') == 'TWILIO') {
//                            // TWILIO API CREDENTIALS
//                            $sid = env('TWILIO_SID');
//                            $token = env('TWILIO_TOKEN');
//
//                            // The TujengePay WhatsApp number
//                            $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886
//
//                            // Initialize the Twilio Client
//                            $twilio = new \Twilio\Rest\Client($sid, $token);
//
//                            $message = $twilio->messages
//                                ->create("whatsapp:" . $user_identifier,
//                                    array(
//                                        "body" => $reply_message,
//                                        "from" => "whatsapp:" . $whatsapp_live_number
//                                    )
//                                );
//                        }
//
//                        if (env('WA_BOT_ENV') == '360') {
//
//
////                    $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
//                            foreach ($bot_responses['bot_responses'] as $bot_response) {
//
//                                $rows[] = [
//                                    "id" => $bot_response->key_word,
//                                    "title" => $bot_response->response_text,
////                                    "description" => $bot_response->response_text,
//                                ];
//                            }
//
//                            $word = "profilename";
//                            $mystring = $bot_responses['bot_step']->step_title;
//
//                            // Test if string contains the word
//                            if (strpos($mystring, $word) !== false) {
//                                Log::info("Word Found: " . $mystring);
//                                $body_text = str_replace("profilename", "*" . $profile_name . "*", $mystring);
//                                Log::info("Replaced reply message: " . $reply_message);
//                            }
//
//                            $client = new \GuzzleHttp\Client();
//
//                            $response = $client->request('POST', 'https://waba.360dialog.io/v1/messages', [
//                                'headers' => [
//                                    'Content-Type' => 'application/json',
//                                    'D360-API-KEY' => 'BFA39DlBEFUc5Es07sVHpgqUAK',
//
//                                ],
//
//                                'body' => json_encode([
//                                    "recipient_type" => "individual",
//                                    "to" => $message_from,
//                                    "type" => "interactive",
//                                    "interactive" => [
//                                        "type" => "list",
////                    "header" => [
////                        "type" => "text",
////                        "text" => "KPCL TOKENS HEADER"
////                    ],
//                                        "body" => [
//                                            "text" => $body_text
//                                        ],
////                    "footer" => [
////                        "text" => "KPLC TOKENS FOOTER"
////                    ],
//                                        "action" => [
//                                            "button" => "Get Started",
//                                            "sections" => [
//                                                [
//                                                    "title" => "get-started",
//                                                    "rows" => $rows
//                                                ],
////                            [
////                                "title" => "your-section",
////                                "rows" => [
////                                    [
////                                        "id" => "un2",
////                                        "title" => "row-title-content",
////                                        "description" => "row-description-content",
////                                    ]
////                                ]
////                            ],
//                                            ]
//                                        ]
//                                    ]])
//                            ]);
//                        }
//                    }

                    if ($channel == env('TELEGRAM_CHANNEL')) {

                        $telegram = new Api(env('TELEGRAM_TOKEN'));

                        $keyboard = [
                            ['1. My cover'],
                            ['2. Benefit balances'],
                            ['3. Cover utilization'],
                            ['4. Claims'],
                            ['5. Pay'],
                            ['6. Premium statement'],
                            ['7. Request for quote'],
                            ['8. Request for letters'],
                            ['9. Buy insurance product'],
                            ['10. Customer care']
                        ];

                        $reply_markup = $telegram->replyKeyboardMarkup([
                            'keyboard' => $keyboard,
                            'resize_keyboard' => true,
                            'one_time_keyboard' => true
                        ]);

                        $response = $telegram->sendMessage([
                            'chat_id' => $user_identifier,
                            'text' => "Hi, Welcome to AAR Kenya Insurance chatbot. Get all your questions answered here quick and fast\nPlease choose an option below to start",
                            'reply_markup' => $reply_markup,
                            'parse_mode' => 'markdown'
                        ]);

                        $messageId = $response->getMessageId();

                    }

                    if ($channel == env('MESSENGER_CHANNEL')) {

                        Log::info('MESSENGER8');

                        //API Url and Access Token, generate this token value on your Facebook App Page
                        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                        $client = new \GuzzleHttp\Client();

                        $response = $client->request('POST', $url, [
                            'headers' => [
                                'Content-Type' => 'application/json',
                            ],
                            'body' => json_encode([
                                'recipient' => [
                                    'id' => $user_identifier,
                                ],
                                'messaging_type' => 'RESPONSE',
                                'message' => [
                                    'text' => 'Pick an item below',
                                    'quick_replies' => [
                                        [
                                            'content_type' => 'text',
                                            'title' => 'My cover',
                                            'payload' => '1',
                                        ],
                                        [
                                            'content_type' => 'text',
                                            'title' => 'Benefit balances',
                                            'payload' => '2',
                                        ],
                                        [
                                            'content_type' => 'text',
                                            'title' => 'Cover utilization',
                                            'payload' => '3',
                                        ],
                                        [
                                            'content_type' => 'text',
                                            'title' => 'Claims',
                                            'payload' => '4',
                                        ],
                                        [
                                            'content_type' => 'text',
                                            'title' => 'Pay',
                                            'payload' => '5',
                                        ],
                                        [
                                            'content_type' => 'text',
                                            'title' => 'Premium statement',
                                            'payload' => '6',
                                        ],
                                        [
                                            'content_type' => 'text',
                                            'title' => 'Request for quote',
                                            'payload' => '7',
                                        ],
                                        [
                                            'content_type' => 'text',
                                            'title' => 'Request for letters',
                                            'payload' => '8',
                                        ],
                                        [
                                            'content_type' => 'text',
                                            'title' => 'Buy insurance product',
                                            'payload' => '9',
                                        ],
                                        [
                                            'content_type' => 'text',
                                            'title' => 'Customer care',
                                            'payload' => '10',
                                        ]
                                    ],
                                ],
                            ])
                        ]);
////Initiate cURL.
//                $ch = curl_init($url);
//
//
////The JSON data.
//                $jsonData = '{
//    "recipient":{
//        "id":"' . $user_identifier . '"
//    },
//    "message":{
//        "text": "'.$reply_message.'"
//    }
//}';
//
////Tell cURL that we want to send a POST request.
//                curl_setopt($ch, CURLOPT_POST, 1);
//
////Attach our encoded JSON string to the POST fields.
//                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
//
////Set the content type to application/json
//                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//
////Execute the request but first check if the message is not empty.
////                if (!empty($input['entry'][0]['messaging'][0]['message'])) {
//                    $result = curl_exec($ch);
////                }


                    }

                    return 'ok';
                }

                return 'ok';
            } else {

                Log::info('NO SESSION ACTIVE');

                $bot_responses = $this->getStartSession($botSessionService, $user_identifier, $channel, $bot_account, $message);

                $reply_message = $bot_responses['bot_step']->step_title;

                $word = "profilename";
                $mystring = $bot_responses['bot_step']->step_title;

                // Test if string contains the word
                if (strpos($mystring, $word) !== false) {
                    Log::info("Word Found: " . $mystring);
                    $reply_message = str_replace("profilename", $profile_name, $mystring);
                    Log::info("Replaced reply message: " . $reply_message);
                }

                foreach ($bot_responses['bot_responses'] as $bot_response) {

                    $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
                }

                if ($channel == env('WHATSAPP_CHANNEL')) {

                    if (env('WA_BOT_ENV') == 'TWILIO') {
                        // TWILIO API CREDENTIALS
                        $sid = env('TWILIO_SID');
                        $token = env('TWILIO_TOKEN');

                        // The TujengePay WhatsApp number
                        $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                        // Initialize the Twilio Client
                        $twilio = new \Twilio\Rest\Client($sid, $token);

                        $message = $twilio->messages
                            ->create("whatsapp:" . $user_identifier,
                                array(
                                    "body" => $reply_message,
                                    "from" => "whatsapp:" . $whatsapp_live_number
                                )
                            );
                    }

                    if (env('WA_BOT_ENV') == '360') {


//                    $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                        foreach ($bot_responses['bot_responses'] as $bot_response) {

                            $rows[] = [
                                "id" => $bot_response->key_word,
                                "title" => $bot_response->response_text,
//                                "description" => $bot_response->response_text,
                            ];
                        }

                        $word = "profilename";
                        $mystring = $bot_responses['bot_step']->step_title;

                        // Test if string contains the word
                        if (strpos($mystring, $word) !== false) {
                            Log::info("Word Found: " . $mystring);
                            $body_text = str_replace("profilename", "*" . $profile_name . "*", $mystring);
                            Log::info("Replaced reply message: " . $reply_message);
                        }

                        $client = new \GuzzleHttp\Client();

                        $response = $client->request('POST', 'https://waba.360dialog.io/v1/messages', [
                            'headers' => [
                                'Content-Type' => 'application/json',
                                'D360-API-KEY' => 'BFA39DlBEFUc5Es07sVHpgqUAK',

                            ],

                            'body' => json_encode([
                                "recipient_type" => "individual",
                                "to" => $message_from,
                                "type" => "interactive",
                                "interactive" => [
                                    "type" => "list",
//                    "header" => [
//                        "type" => "text",
//                        "text" => "KPCL TOKENS HEADER"
//                    ],
                                    "body" => [
                                        "text" => $body_text
                                    ],
//                    "footer" => [
//                        "text" => "KPLC TOKENS FOOTER"
//                    ],
                                    "action" => [
                                        "button" => "Get Started",
                                        "sections" => [
                                            [
                                                "title" => "get-started",
                                                "rows" => $rows
                                            ],
//                            [
//                                "title" => "your-section",
//                                "rows" => [
//                                    [
//                                        "id" => "un2",
//                                        "title" => "row-title-content",
//                                        "description" => "row-description-content",
//                                    ]
//                                ]
//                            ],
                                        ]
                                    ]
                                ]])
                        ]);
                    }
                }

                if ($channel == env('TELEGRAM_CHANNEL')) {

                    $telegram = new Api(env('TELEGRAM_TOKEN'));

                    $keyboard = [
                        ['1. My cover'],
                        ['2. Benefit balances'],
                        ['3. Cover utilization'],
                        ['4. Claims'],
                        ['5. Pay'],
                        ['6. Premium statement'],
                        ['7. Request for quote'],
                        ['8. Request for letters'],
                        ['9. Buy insurance product'],
                        ['10. Customer care']
                    ];

                    $reply_markup = $telegram->replyKeyboardMarkup([
                        'keyboard' => $keyboard,
                        'resize_keyboard' => true,
                        'one_time_keyboard' => true
                    ]);

                    $response = $telegram->sendMessage([
                        'chat_id' => $user_identifier,
                        'text' => "Hi, Welcome to AAR Kenya Insurance chatbot. Get all your questions answered here quick and fast\nPlease choose an option below to start",
                        'reply_markup' => $reply_markup,
                        'parse_mode' => 'markdown'
                    ]);

                    $messageId = $response->getMessageId();

                }

                if ($channel == env('MESSENGER_CHANNEL')) {

                    Log::info('MESSENGER8');

                    //API Url and Access Token, generate this token value on your Facebook App Page
                    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                    $client = new \GuzzleHttp\Client();

                    $response = $client->request('POST', $url, [
                        'headers' => [
                            'Content-Type' => 'application/json',
                        ],
                        'body' => json_encode([
                            'recipient' => [
                                'id' => $user_identifier,
                            ],
                            'messaging_type' => 'RESPONSE',
                            'message' => [
                                'text' => 'Pick an item below',
                                'quick_replies' => [
                                    [
                                        'content_type' => 'text',
                                        'title' => 'My cover',
                                        'payload' => '1',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Benefit balances',
                                        'payload' => '2',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Cover utilization',
                                        'payload' => '3',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Claims',
                                        'payload' => '4',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Pay',
                                        'payload' => '5',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Premium statement',
                                        'payload' => '6',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Request for quote',
                                        'payload' => '7',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Request for letters',
                                        'payload' => '8',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Buy insurance product',
                                        'payload' => '9',
                                    ],
                                    [
                                        'content_type' => 'text',
                                        'title' => 'Customer care',
                                        'payload' => '10',
                                    ]
                                ],
                            ],
                        ])
                    ]);
////Initiate cURL.
//                $ch = curl_init($url);
//
//
////The JSON data.
//                $jsonData = '{
//    "recipient":{
//        "id":"' . $user_identifier . '"
//    },
//    "message":{
//        "text": "'.$reply_message.'"
//    }
//}';
//
////Tell cURL that we want to send a POST request.
//                curl_setopt($ch, CURLOPT_POST, 1);
//
////Attach our encoded JSON string to the POST fields.
//                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
//
////Set the content type to application/json
//                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//
////Execute the request but first check if the message is not empty.
////                if (!empty($input['entry'][0]['messaging'][0]['message'])) {
//                    $result = curl_exec($ch);
////                }


                }

                return 'ok';
            }
        } else {

            // Create a new bot account
            $created_bot_account = $botAccountsService->storeAccount($user_identifier,
                $channel,
                new WhatsappAccountRepository(),
                new TelegramAccountRepository(),
                new MessengerAccountRepository());



            $bot_responses = $this->getStartSession($botSessionService, $user_identifier, $channel, $created_bot_account, $message);

            $reply_message = $bot_responses['bot_step']->step_title;

            $word = "profilename";
            $mystring = $bot_responses['bot_step']->step_title;

            // Test if string contains the word
            if (strpos($mystring, $word) !== false) {
                Log::info("Word Found: " . $mystring);
                $reply_message = str_replace("profilename", $profile_name, $mystring);
                Log::info("Replaced reply message: " . $reply_message);
            }

            foreach ($bot_responses['bot_responses'] as $bot_response) {

                $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
            }

            if ($channel == env('WHATSAPP_CHANNEL')) {

                if (env('WA_BOT_ENV') == 'TWILIO') {
                    // TWILIO API CREDENTIALS
                    $sid = env('TWILIO_SID');
                    $token = env('TWILIO_TOKEN');

                    // The TujengePay WhatsApp number
                    $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                    // Initialize the Twilio Client
                    $twilio = new \Twilio\Rest\Client($sid, $token);

                    $message = $twilio->messages
                        ->create("whatsapp:" . $user_identifier,
                            array(
                                "body" => $reply_message,
                                "from" => "whatsapp:" . $whatsapp_live_number
                            )
                        );
                }

                if (env('WA_BOT_ENV') == '360') {


//                    $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                    foreach ($bot_responses['bot_responses'] as $bot_response) {

                        $rows[] = [
                            "id" => $bot_response->key_word,
                            "title" => $bot_response->response_text,
//                            "description" => $bot_response->response_text,
                        ];
                    }

                    $word = "profilename";
                    $mystring = $bot_responses['bot_step']->step_title;

                    // Test if string contains the word
                    if (strpos($mystring, $word) !== false) {
                        Log::info("Word Found: " . $mystring);
                        $body_text = str_replace("profilename", "*" . $profile_name . "*", $mystring);
                        Log::info("Replaced reply message: " . $reply_message);
                    }

                    $client = new \GuzzleHttp\Client();

                    $response = $client->request('POST', 'https://waba.360dialog.io/v1/messages', [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'D360-API-KEY' => 'BFA39DlBEFUc5Es07sVHpgqUAK',

                        ],

                        'body' => json_encode([
                            "recipient_type" => "individual",
                            "to" => $message_from,
                            "type" => "interactive",
                            "interactive" => [
                                "type" => "list",
//                    "header" => [
//                        "type" => "text",
//                        "text" => "KPCL TOKENS HEADER"
//                    ],
                                "body" => [
                                    "text" => $body_text
                                ],
//                    "footer" => [
//                        "text" => "KPLC TOKENS FOOTER"
//                    ],
                                "action" => [
                                    "button" => "Get Started",
                                    "sections" => [
                                        [
                                            "title" => "get-started",
                                            "rows" => $rows
                                        ],
//                            [
//                                "title" => "your-section",
//                                "rows" => [
//                                    [
//                                        "id" => "un2",
//                                        "title" => "row-title-content",
//                                        "description" => "row-description-content",
//                                    ]
//                                ]
//                            ],
                                    ]
                                ]
                            ]])
                    ]);
                }
            }

            if ($channel == env('TELEGRAM_CHANNEL')) {

                $telegram = new Api(env('TELEGRAM_TOKEN'));

                $keyboard = [
                    ['1. My cover'],
                    ['2. Benefit balances'],
                    ['3. Cover utilization'],
                    ['4. Claims'],
                    ['5. Pay'],
                    ['6. Premium statement'],
                    ['7. Request for quote'],
                    ['8. Request for letters'],
                    ['9. Buy insurance product'],
                    ['10. Customer care']
                ];

                $reply_markup = $telegram->replyKeyboardMarkup([
                    'keyboard' => $keyboard,
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ]);

                $response = $telegram->sendMessage([
                    'chat_id' => $user_identifier,
                    'text' => "Hi, Welcome to AAR Kenya Insurance chatbot. Get all your questions answered here quick and fast\nPlease choose an option below to start",
                    'reply_markup' => $reply_markup,
                    'parse_mode' => 'markdown'
                ]);

                $messageId = $response->getMessageId();

            }

            if ($channel == env('MESSENGER_CHANNEL')) {

                Log::info('MESSENGER8');

                //API Url and Access Token, generate this token value on your Facebook App Page
                $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

                $client = new \GuzzleHttp\Client();

                $response = $client->request('POST', $url, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'body' => json_encode([
                        'recipient' => [
                            'id' => $user_identifier,
                        ],
                        'messaging_type' => 'RESPONSE',
                        'message' => [
                            'text' => 'Pick an item below',
                            'quick_replies' => [
                                [
                                    'content_type' => 'text',
                                    'title' => 'My cover',
                                    'payload' => '1',
                                ],
                                [
                                    'content_type' => 'text',
                                    'title' => 'Benefit balances',
                                    'payload' => '2',
                                ],
                                [
                                    'content_type' => 'text',
                                    'title' => 'Cover utilization',
                                    'payload' => '3',
                                ],
                                [
                                    'content_type' => 'text',
                                    'title' => 'Claims',
                                    'payload' => '4',
                                ],
                                [
                                    'content_type' => 'text',
                                    'title' => 'Pay',
                                    'payload' => '5',
                                ],
                                [
                                    'content_type' => 'text',
                                    'title' => 'Premium statement',
                                    'payload' => '6',
                                ],
                                [
                                    'content_type' => 'text',
                                    'title' => 'Request for quote',
                                    'payload' => '7',
                                ],
                                [
                                    'content_type' => 'text',
                                    'title' => 'Request for letters',
                                    'payload' => '8',
                                ],
                                [
                                    'content_type' => 'text',
                                    'title' => 'Buy insurance product',
                                    'payload' => '9',
                                ],
                                [
                                    'content_type' => 'text',
                                    'title' => 'Customer care',
                                    'payload' => '10',
                                ]
                            ],
                        ],
                    ])
                ]);
////Initiate cURL.
//                $ch = curl_init($url);
//
//
////The JSON data.
//                $jsonData = '{
//    "recipient":{
//        "id":"' . $user_identifier . '"
//    },
//    "message":{
//        "text": "'.$reply_message.'"
//    }
//}';
//
////Tell cURL that we want to send a POST request.
//                curl_setopt($ch, CURLOPT_POST, 1);
//
////Attach our encoded JSON string to the POST fields.
//                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
//
////Set the content type to application/json
//                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//
////Execute the request but first check if the message is not empty.
////                if (!empty($input['entry'][0]['messaging'][0]['message'])) {
//                    $result = curl_exec($ch);
////                }


            }

            return 'ok';
        }
    }

    public function getStartSession(BotSessionService $botSessionService, $user_identifier, $channel, $created_bot_account, $message)
    {
        // Get Initiate Session
        $bot_session = $botSessionService->getBotSession($channel, 'aar');

        // Process the bot session
        $session = $botSessionService->processSession($user_identifier,
            $channel,
            $created_bot_account,
            $bot_session,
            new WhatsappSessionRepository(),
            new TelegramSessionRepository(),
            new MessengerSessionRepository());

        $whatsappSessionRepository = new WhatsappSessionRepository();

        //Process the bot session step
        $bot_step = $botSessionService->getBotStep($message, $channel, $bot_session);

        // Get the session step
        $botSessionService->setSessionStep($session,
            $channel,
            $user_identifier,
            $message,
            $created_bot_account,
            $bot_step,
            new WhatsappSessionRepository(),
            new TelegramSessionRepository(),
            new MessengerSessionRepository());

        // Get bot output response using user key word, channel and session
        $bot_responses = $botSessionService->getBotResponses($message, $channel, $bot_session, $bot_step);

        return [
            'bot_step' => $bot_step,
            'bot_responses' => $bot_responses
        ];
    }

    public function getSession(BotSessionService $botSessionService, $user_identifier, $channel, $created_bot_account, $message)
    {

        // Get Initiate Session
        $bot_session = $botSessionService->getBotSession($channel, $message);

        Log::info('Session Name : ' . $bot_session->session_name);

        // Process the bot session
        $session = $botSessionService->processSession($user_identifier,
            $channel,
            $created_bot_account,
            $bot_session,
            new WhatsappSessionRepository(),
            new TelegramSessionRepository(),
            new MessengerSessionRepository());

        //Process the bot session step
        $bot_step = $botSessionService->getInitialBotStep($message, $channel, $bot_session);

        // Get the session step
        $botSessionService->setSessionStep($session,
            $channel,
            $user_identifier,
            $message,
            $created_bot_account,
            $bot_step,
            new WhatsappSessionRepository(),
            new TelegramSessionRepository(),
            new MessengerSessionRepository());

        // Get bot output response using user key word, channel and session
        $bot_responses = $botSessionService->getBotResponses($message, $channel, $bot_session, $bot_step);

        Log::info('MESSENGER');

        return [
            'bot_step' => $bot_step,
            'bot_responses' => $bot_responses
        ];
    }

    public function confirmMessenger()
    {

        $challenge = $_REQUEST['hub_challenge'];
        $verify_token = $_REQUEST['hub_verify_token'];

// Set this Verify Token Value on your Facebook App
        if ($verify_token === '*jayjay123#') {
            echo $challenge;
        }
    }

    public function messengerUpdates(BotAccountsService $botAccountsService,
                                     BotSessionService $botSessionService,
                                     WhatsappSessionRepository $whatsappSessionRepository,
                                     BotSessionRepository $botSessionRepository,
                                     BotServices $botServices,
                                     WhatsAppServiceApi $whatsAppServiceApi)
    {

        $input = json_decode(file_get_contents('php://input'), true);

//        file_put_contents("data.json", file_get_contents('php://input'));

// Get the Senders Graph ID
        $sender = $input['entry'][0]['messaging'][0]['sender']['id'];

// Get the returned message
        $message = $input['entry'][0]['messaging'][0]['message']['text'];

        if (array_key_exists('quick_reply', $input['entry'][0]['messaging'][0]['message'])) {

            if (array_key_exists('payload', $input['entry'][0]['messaging'][0]['message']['quick_reply'])) {

                $message = $input['entry'][0]['messaging'][0]['message']['quick_reply']['payload'];

                Log::info('QUICK REPLY MESSAGE ' . $message);
            }
        }

        $channel = env('MESSENGER_CHANNEL');

        Log::info('ME ' . $message);

        $this->startEngine($botAccountsService,
            $sender,
            $channel,
            $botSessionService,
            $message,
            $whatsappSessionRepository,
            $botSessionRepository,
            $botServices,
            $whatsAppServiceApi,
            $sender,
            $message,
            ""
        );
    }

    public function botUpdates(Request $request,
                               BotAccountsService $botAccountsService,
                               BotSessionService $botSessionService,
                               WhatsappSessionRepository $whatsappSessionRepository,
                               BotSessionRepository $botSessionRepository,
                               BotServices $botServices,
                               WhatsAppServiceApi $whatsAppServiceApi)
    {

//        file_put_contents("data.json", $json = response()->json($request->all()));

        $message = $request->message;

        if (!is_null($message)) {
            Log::info('Update Id : ' . $request->update_id);

            $from = array_key_exists('from', $message) ? $message['from'] : null;

            $from_id = array_key_exists('id', $from) ? $from['id'] : null;

            $is_bot = array_key_exists('is_bot', $from) ? $from['is_bot'] : null;

            $first_name = array_key_exists('first_name', $from) ? $from['first_name'] : null;

            $last_name = array_key_exists('last_name', $from) ? $from['last_name'] : null;

            $user_name = array_key_exists('username', $from) ? $from['username'] : null;

            $language_code = array_key_exists('language_code', $from) ? $from['language_code'] : null;

            $message_date = array_key_exists('date', $message) ? $message['date'] : null;

            $message_text = array_key_exists('text', $message) ? $message['text'] : null;

            $chat = array_key_exists('chat', $message) ? $message['chat'] : null;

            $chat_id = array_key_exists('id', $chat) ? $chat['id'] : null;

            $chat_first_name = array_key_exists('first_name', $chat) ? $chat['first_name'] : null;

            $chat_last_name = array_key_exists('last_name', $chat) ? $chat['last_name'] : null;

            $chat_username = array_key_exists('username', $chat) ? $chat['username'] : null;

            $chat_type = array_key_exists('type', $chat) ? $chat['type'] : null;

            $update_id = $request->update_id;

            Log::info('Message :' . $message['message_id']);
            Log::info('From Id :' . $from_id);
            Log::info('Is Bot :' . $is_bot);
            Log::info('First Name :' . $first_name);
            Log::info('Last Name : ' . $last_name);
            Log::info('Username :' . $user_name);
            Log::info('Language :' . $language_code);
            Log::info('Chat Id :' . $chat_id);
            Log::info('Chat First Name :' . $chat_first_name);
            Log::info('Chat Last Name :' . $chat_last_name);
            Log::info('Chat Username :' . $chat_username);
            Log::info('Chat Type :' . $chat_type);
            Log::info('Message Date : ' . $message_date);
            Log::info('Message Text :' . $message_text);

        }


        Log::info('kikuh');

        $channel = env('TELEGRAM_CHANNEL');

//        dd($message_text);

        Log::info('Update Id : ' . $request->update_id);


        if (isset($request->callback_query['data'])) {

            $data = $request->callback_query['data'];

            $call_back_query_id = $request->callback_query['id'];

            $from = $request->callback_query['from'];

            $chat = $request->callback_query['message']['chat'];

            $chat_id = $chat['id'];

            $message_text = $data;

            $client = new \GuzzleHttp\Client();

//            $res = $client->request('GET', 'https://api.telegram.org/bot1704393829:AAEpMNWl4RBjdx7H2tVpiEMmBdKZpesQJVE/answerCallbackQuery?callback_query_id='.$call_back_query_id);
        }


        $this->startEngine($botAccountsService,
            $chat_id,
            $channel,
            $botSessionService,
            $message_text,
            $whatsappSessionRepository,
            $botSessionRepository,
            $botServices,
            $whatsAppServiceApi,
            $from,
            $message_text,
            ""
        );

//        $bot_account = $botAccountsService->getAccount($chat_id, $channel, new WhatsappAccountRepository(), new TelegramAccountRepository());


//        $telegram = new Api(env('TELEGRAM_TOKEN'));
//
//        $response = $telegram->sendMessage([
//            'chat_id' => $chat_id,
//            'text' => 'Hello World'
//        ]);
//
//        $messageId = $response->getMessageId();
    }

}
