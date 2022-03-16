<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\User;
use App\Models\Email;
use App\Models\County;
use App\Mail\OrderMail;
use App\Models\Disease;
use App\Models\Product;
use Twilio\Rest\Client;
use App\Models\BotResponse;
use App\Models\OshoProduct;
use Illuminate\Http\Request;
use App\Services\BotServices;

use App\Models\WhatsappAccount;
use App\Models\OshoDistributors;
use App\Services\BotSessionService;
use Illuminate\Support\Facades\Log;
use App\Services\BotAccountsService;
use App\Services\WhatsAppServiceApi;
use Illuminate\Support\Facades\Mail;
use App\Models\UniqueWhatsappMessage;
use App\Models\UserSessionStep;
use App\Repositories\BotSessionRepository;
use App\Repositories\WhatsappAccountRepository;
use App\Repositories\WhatsappSessionRepository;


class ChatbotController extends Controller
{

    public function input(Request $request)
    {
        // Read the variables sent via POST from Africastalking API
        $sessionId = $request->get("sessionId");
        $serviceCode = $request->get("serviceCode");
        $phoneNumber = $request->get("phoneNumber");
        $text = $request->get("text");

        // use explode to split the string text response from Africa's talking gateway into an array.
        $ussd_string_exploded = explode("*", $text);
        // Get ussd menu level number from the gateway
        $level = count($ussd_string_exploded);

        if ($text == "") {
            // This is the first request. Note how we start the response with CON
            $response = "CON Welcome, You will receive a\nWhatsApp message.\nReply to continue\n";
            $response .= "1. Is " . $phoneNumber . " your\nWhatsApp number?\n";
            $response .= "2. No, I have another WhatsApp number\n";
        } else if ($text == "1") {
            // Business logic for first level response
            $response = "CON Welcome to Osho Chemicals \n";
            $response .= "1. Register \n";
        } elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 1 && $level == 2) {
            $response = "CON Please enter your email";
        } elseif ($ussd_string_exploded[0] == 1 && $ussd_string_exploded[1] == 1 && $level == 3) {
            // save data in the database
            $user = new User();
            if (User::where('phoneNumber', $phoneNumber)->exists()) {
                $response = "END You have already registered.\nCheck your WhatsApp!";
            } else {
                Log::info("email: " . $ussd_string_exploded[2]);
                $user->email = $ussd_string_exploded[2];
                $user->phoneNumber = $phoneNumber;
                $user->save();
                $response = "END Your data has been captured successfully.\nCheck your WhatsApp!";
            }

            $sid = getenv("TWILIO_SID");
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio = new Client($sid, $token);
            $message = $twilio->messages
                ->create(
                    "whatsapp:" . $phoneNumber, // to
                    [
                        "from" => "whatsapp:+14155238886",
                        "body" => "Your {{account has been activated. Type *hi* to start.}}"
                    ]
                );
        } else if ($text == "2" && $ussd_string_exploded[0] == 2) {
            // Business logic for first level response
            // This is a terminal request. Note how we start the response with END
            $response = "CON Enter your WhatsApp number E.g\n*+254712345678*";
        } else if ($ussd_string_exploded[0] == 2 && $level == 2) {
            $guest = new User();
            $guest->phoneNumber = $ussd_string_exploded[1];
            $guest->save();
            Log::info("number: " . $ussd_string_exploded[1]);
            $response = "CON Now, enter your email\n";
        } else if ($ussd_string_exploded[0] == 2 && $level == 3) {
            $response = "END Check your whatsapp!";
            $user = User::where('phoneNumber', $ussd_string_exploded[1])->first();
            Log::info("number: " . $ussd_string_exploded[2]);
            Log::info("user: " . $user);
            $user->email = $ussd_string_exploded[2];
            $user->save();

            $sid = getenv("TWILIO_SID");
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio = new Client($sid, $token);
            $message = $twilio->messages
                ->create(
                    "whatsapp:" . $phoneNumber, // to
                    [
                        "from" => "whatsapp:+14155238886",
                        "body" => "Your {{account has been activated. Type *hi* to start.}}"
                    ]
                );
        }

        // Echo the response back to the API
        header('Content-type: text/plain');
        echo $response;
    }

    public function botEngine(
        Request $request,
        BotAccountsService $botAccountsService,
        BotSessionService $botSessionService,
        WhatsappSessionRepository $whatsappSessionRepository,
        BotSessionRepository $botSessionRepository,
        BotServices $botServices,
        WhatsAppServiceApi $whatsAppServiceApi
    ) {

        //        file_put_contents("data.json", $json = response()->json($request->all()));

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

            $profile_name = $data['ProfileName'];
            Log::info("Whatsapp profile name:  " . $profile_name);
        }

        if (env('WA_BOT_ENV') == '360') {

            Log::info('NEW BOT HIT');

            $data = $request->all();

            if (isset($data['contacts'])) {

                $profile_name = isset($data['contacts'][0]['profile']['name']) ? $data['contacts'][0]['profile']['name'] : '';
            } else {

                $profile_name = "";
            }


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


            Log::info('PROFILE NAME : ' . $profile_name);

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
        }


        $this->startEngine(
            $botAccountsService,
            $user_identifier,
            $channel,
            $botSessionService,
            $message,
            $whatsappSessionRepository,
            $botSessionRepository,
            $botServices,
            $whatsAppServiceApi,
            $message_from,
            $profile_name
        );
    }

    //
    public function startEngine(
        BotAccountsService $botAccountsService,
        $user_identifier,
        $channel,
        BotSessionService $botSessionService,
        $message,
        WhatsappSessionRepository $whatsappSessionRepository,
        BotSessionRepository $botSessionRepository,
        BotServices $botServices,
        WhatsAppServiceApi $whatsAppServiceApi,
        $message_from,
        $profile_name
    ) {

        // Get Account From Channel and userIdentifier
        $bot_account = $botAccountsService->getAccount(
            $user_identifier,
            $channel,
            new WhatsappAccountRepository()
        );


        Log::info('AS');

        if (!is_null($bot_account)) {

            $active_session = $botSessionService->checkForActiveSession(
                $bot_account,
                $channel,
                new WhatsappSessionRepository()
            );

            // check if session keyword
            if ($botSessionService->checkIfSessionExistsByName($channel, $message, new BotSessionRepository())) {

                Log::info('uid' . $user_identifier);

                $botSessionService->deactivateBotSession(
                    $channel,
                    $user_identifier,
                    $whatsappSessionRepository,
                );
                //
                $users = WhatsappAccount::where('phone_number', $user_identifier)->first();
                Log::info("County Registered already");
                //if user is alreday registered using county to skip the registration process
                if ($users->county != null) {
                    Log::info("Skip Registration");

                    // Use the existing bot account
                    $created_bot_account = $users;
                    $bot_responses = $this->getStartSession($botSessionService, $user_identifier, $channel, $created_bot_account, $message, $profile_name);

                    $reply_message = $bot_responses['bot_step']->step_title;

                    foreach ($bot_responses['bot_responses'] as $bot_response) {

                        $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
                    }

                    Log::info("Start Session Reply Message 1: " . $reply_message);
                    //save user start response step
                    $client = User::where('phoneNumber', $user_identifier)->first();
                    $user_steps = new UserSessionStep();
                    $user_steps->message = $message;
                    $user_steps->botSessionStep = $reply_message;
                    $client->steps()->save($user_steps);
                } else {
                    $bot_responses = $this->getSession($botSessionService, $user_identifier, $channel, $bot_account, $message, $profile_name);

                    $reply_message = $bot_responses['bot_step']->step_title;

                    foreach ($bot_responses['bot_responses'] as $bot_response) {

                        $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
                    }
                    Log::info("Start Session Message 1: " . $reply_message);
                    //save user start response step
                    $client = User::where('phoneNumber', $user_identifier)->first();
                    $user_steps = new UserSessionStep();
                    $user_steps->message = $message;
                    $user_steps->botSessionStep = $reply_message;
                    $client->steps()->save($user_steps);
                }
                //
                if ($channel == env('WHATSAPP_CHANNEL')) {

                    if (env('WA_BOT_ENV') == 'TWILIO') {
                        // TWILIO API CREDENTIALS
                        $sid = 'AC86868678f517b851d044e933039b8a1c';
                        $token = '3e5c1042b1c7d6a6e6717e7d9818f38c'; 

                        // The TujengePay WhatsApp number
                        $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                        // Initialize the Twilio Client
                        $twilio = new \Twilio\Rest\Client($sid, $token);

                        $message = $twilio->messages
                            ->create(
                                "whatsapp:" . $user_identifier,
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

                return 'ok';
            } elseif ($active_session) {

                Log::info('AS1');


                $active_session_step = $botSessionService->getActiveBotStep(
                    $bot_account,
                    $channel,
                    new WhatsappSessionRepository()
                );


                Log::info('ASALS ' . $active_session_step->bot_session_step->allow_back);


                $session = $botSessionService->getActiveSession(
                    $channel,
                    $user_identifier,
                    new WhatsappSessionRepository()
                );

                Log::info('res exists');

                $bot_session = $session->bot_session;

                Log::info('ASST ID ' . $active_session_step->id);

                if ($active_session_step->bot_session_step->is_initial_step && $bot_session->session_key_word == 0) {
                    $service_methods = (array)json_decode($active_session_step->bot_session_step->service_methods);
                    foreach ($service_methods as $service_method) {
                        if ($service_method->method_type == 'registration') {
                            Log::info("COUNTY REGISTRATION");
                            $next_bot_step = $botSessionService->getNextBotStep($channel, $active_session_step->bot_session_step, $message);
                        } else {
                            $next_bot_session = $botSessionService->getNextBotSession($channel, $message, new BotSessionRepository());

                            $session = $botSessionService->processSession(
                                $user_identifier,
                                $channel,
                                $bot_account,
                                $next_bot_session,
                                new WhatsappSessionRepository()
                            );

                            $bot_session = $next_bot_session;

                            Log::info('NBS' . $next_bot_session->session_key_word);

                            $next_bot_step = $botSessionService->getZeroBotSessionStep($channel, $next_bot_session, new BotSessionRepository());

                            Log::info('NS' . $next_bot_step->session_step_key);
                        }
                    }
                } else {

                    $next_bot_step = $botSessionService->getNextBotStep($channel, $active_session_step->bot_session_step, $message);
                }

                $bot_session_step = $active_session_step->bot_session_step;

                if ($active_session_step->bot_session_step->allow_back) {

                    if ($message == '0') {

                        $session = $botSessionService->getActiveSession(
                            $channel,
                            $user_identifier,
                            new WhatsappSessionRepository()
                        );

                        $bot_session = $session->bot_session;

                        Log::info('Lets get previous bot step');

                        Log::info('ASS ' . $active_session_step->bot_session_step);


                        $next_bot_step = $botSessionService->getPreviousBotStep($channel, $active_session_step->bot_session_step, $message);

                        Log::info('BSS ' . $next_bot_step);

                        $bot_session_step = $next_bot_step;
                    }
                }

                Log::info('BOT SESSION STEP ' . $bot_session_step);

                //save user info
                $client = User::where('phoneNumber', $user_identifier)->first();
                if ($client == null) {
                    $user = new User();
                    $user->phoneNumber = $user_identifier;
                    $user->userName = $profile_name;
                    $user->save();
                }

                //save user start response step
                // $client = User::where('phoneNumber', $user_identifier)->first();
                // $user_steps = new UserSessionStep();
                // $user_steps->message = $message;
                // $user_steps->botSessionStep = $bot_session_step;
                // $client->steps()->save($user_steps);


                //service
                if ($bot_session_step->service_methods != null) {

                    Log::info('ARE WE HERE');

                    $service_methods = (array)json_decode($bot_session_step->service_methods);

                    foreach ($service_methods as $service_method) {
                        if ($service_method->method_type == 'get_county') {
                            Log::info('County Information');
                            if ($message == 0) {
                                //back button
                                $reply_message = "\n";
                            } else if ($message == 1) {

                                //get all counties
                                $counties = County::all();
                                $reply_message = "Type in the number to select\nan option below👇🏾to get an\nAgrovet / Agro dealer.\n\n";

                                $position = 1;
                                foreach ($counties as $county) {
                                    $reply_message .= $position . " " . $county->name . "\n";
                                    $position++;
                                }

                                $reply_message .= "\nType *0* to go back\nType *99* to go back home";
                                Log::info("County bot response: " . $reply_message);

                                //save user start response step
                                $client = User::where('phoneNumber', $user_identifier)->first();
                                $user_steps = new UserSessionStep();
                                $user_steps->message = $message;
                                $user_steps->botSessionStep = $reply_message;
                                $client->steps()->save($user_steps);

                                if ($channel == env('WHATSAPP_CHANNEL')) {

                                    if (env('WA_BOT_ENV') == 'TWILIO') {
                                        // TWILIO API CREDENTIALS
                                        $sid = 'AC86868678f517b851d044e933039b8a1c';
                                        $token = '3e5c1042b1c7d6a6e6717e7d9818f38c'; 

                                        // The TujengePay WhatsApp number
                                        $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                        // Initialize the Twilio Client
                                        $twilio = new \Twilio\Rest\Client($sid, $token);

                                        $message = $twilio->messages
                                            ->create(
                                                "whatsapp:" . $user_identifier,
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
                            } else if ($message == 2) {
                                $reply_message = " ";

                                if ($channel == env('WHATSAPP_CHANNEL')) {

                                    if (env('WA_BOT_ENV') == 'TWILIO') {
                                        // TWILIO API CREDENTIALS
                                        $sid = 'AC86868678f517b851d044e933039b8a1c';
                                        $token = '3e5c1042b1c7d6a6e6717e7d9818f38c'; 

                                        // The TujengePay WhatsApp number
                                        $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                        // Initialize the Twilio Client
                                        $twilio = new \Twilio\Rest\Client($sid, $token);

                                        $message = $twilio->messages
                                            ->create(
                                                "whatsapp:" . $user_identifier,
                                                array(
                                                    "body" => $reply_message,
                                                    "from" => "whatsapp:" . $whatsapp_live_number
                                                )
                                            );
                                    }

                                    //                                    if (env('WA_BOT_ENV') == '360') {
                                    //
                                    //
                                    //                                        $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                                    //                                    }
                                }
                            } else if ($message > 2) {
                                $reply_message = "Oops🙊wrong option. Type *99* to\ngo back home";
                                Log::info("County wrong option response: " . $reply_message);

                                //save user start response step
                                $client = User::where('phoneNumber', $user_identifier)->first();
                                $user_steps = new UserSessionStep();
                                $user_steps->message = $message;
                                $user_steps->botSessionStep = $reply_message;
                                $client->steps()->save($user_steps);

                                if ($channel == env('WHATSAPP_CHANNEL')) {

                                    if (env('WA_BOT_ENV') == 'TWILIO') {
                                        // TWILIO API CREDENTIALS
                                        $sid = 'AC86868678f517b851d044e933039b8a1c';
                                        $token = '3e5c1042b1c7d6a6e6717e7d9818f38c'; 

                                        // The TujengePay WhatsApp number
                                        $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                        // Initialize the Twilio Client
                                        $twilio = new \Twilio\Rest\Client($sid, $token);

                                        $message = $twilio->messages
                                            ->create(
                                                "whatsapp:" . $user_identifier,
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
                            }
                        }
                        if ($service_method->method_type == 'get_supplier') {

                            if ($message <= County::all()->count()) {

                                $county = County::where('id', $message)->first();
                                Log::info('County Info: ' . $county);
                                $reply_message = "Here is a list of Agrovet suppliers\nin " . $county->name . " County.👇🏾\n\n";

                                $suppliers = OshoDistributors::where('countyDimension', $county->name)->get();
                                Log::info("address: " . $suppliers);
                                Log::info("Count: " . $suppliers->count());

                                foreach ($suppliers as $supplier) {

                                    $reply_message .= $supplier->distributorName . ":\n" . $supplier->phoneNumber . "\n\n";
                                }

                                $reply_message .= "\nType *99* to go back home";

                                Log::info("Supplier bot response: " . $reply_message);
                            } else {
                                $reply_message = "Oops🙊wrong option. Type *99* to\ngo back home";
                                Log::info("Supplier wrong option response: " . $reply_message);

                                //save user start response step
                                $client = User::where('phoneNumber', $user_identifier)->first();
                                $user_steps = new UserSessionStep();
                                $user_steps->message = $message;
                                $user_steps->botSessionStep = $reply_message;
                                $client->steps()->save($user_steps);

                                if ($channel == env('WHATSAPP_CHANNEL')) {

                                    if (env('WA_BOT_ENV') == 'TWILIO') {
                                        // TWILIO API CREDENTIALS
                                        $sid = 'AC86868678f517b851d044e933039b8a1c';
                                        $token = '3e5c1042b1c7d6a6e6717e7d9818f38c'; 

                                        // The TujengePay WhatsApp number
                                        $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                        // Initialize the Twilio Client
                                        $twilio = new \Twilio\Rest\Client($sid, $token);

                                        $message = $twilio->messages
                                            ->create(
                                                "whatsapp:" . $user_identifier,
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
                            }

                            //save user start response step
                            $client = User::where('phoneNumber', $user_identifier)->first();
                            $user_steps = new UserSessionStep();
                            $user_steps->message = $message;
                            $user_steps->botSessionStep = $reply_message;
                            $client->steps()->save($user_steps);

                            if ($channel == env('WHATSAPP_CHANNEL')) {

                                if (env('WA_BOT_ENV') == 'TWILIO') {
                                    // TWILIO API CREDENTIALS
                                    $sid = 'AC86868678f517b851d044e933039b8a1c';
                                    $token = '3e5c1042b1c7d6a6e6717e7d9818f38c'; 

                                    // The TujengePay WhatsApp number
                                    $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                    // Initialize the Twilio Client
                                    $twilio = new \Twilio\Rest\Client($sid, $token);

                                    $message = $twilio->messages
                                        ->create(
                                            "whatsapp:" . $user_identifier,
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
                        }
                        if ($service_method->method_type == 'send_email') {
                            Log::info("Save Email");
                            $text = $message;
                            Log::info("Other crop info: " . $text);
                            $email = new Email();
                            $email->phone_number = $user_identifier;
                            $email->email_message = $text;
                            $email->save();
                            Log::info("Email info saved successfully");

                            $reply_message = "An email has been sent to customer\ncare for a human agent to assist.\n\nType *99* to go back home.";
                            Mail::to('customercare@oshochem.com')->send(new OrderMail($email));
                            // Mail::to('derrickmbugua50@gmail.com')->send(new OrderMail($email));
                            Log::info("Email bot response: " . $reply_message);

                            //save user start response step
                            $client = User::where('phoneNumber', $user_identifier)->first();
                            $user_steps = new UserSessionStep();
                            $user_steps->message = $text;
                            $user_steps->botSessionStep = $reply_message;
                            $client->steps()->save($user_steps);

                            if ($channel == env('WHATSAPP_CHANNEL')) {

                                if (env('WA_BOT_ENV') == 'TWILIO') {
                                    // TWILIO API CREDENTIALS
                                    $sid = 'AC86868678f517b851d044e933039b8a1c';
                                    $token = '3e5c1042b1c7d6a6e6717e7d9818f38c'; 

                                    // The TujengePay WhatsApp number
                                    $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                    // Initialize the Twilio Client
                                    $twilio = new \Twilio\Rest\Client($sid, $token);

                                    $message = $twilio->messages
                                        ->create(
                                            "whatsapp:" . $user_identifier,
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
                        }

                        if ($service_method->method_type == 'order') {

                            if ($message == 10) {
                                $reply_message = "*Tonoricin*\nInjectable phosphorus (4-dimethylamino-2-methylphenyl-phosphinic acid). Tonoricin contains Organic Phosphorus very important in energy metabolism, replenishing serum phosphorus levels, supporting liver function and stimulating fatigued smooth and cardiac muscle.\n*Indications:* \n• Treating Metabolic disorder like ketosis in cattle, poor feeding disease stress or over exhaustion.\n•  Treating Reproductive problems like Metritis, infertility, delayed heat or lack of visible heat signs. \n• Treatment of Muscular disorders E.g., in Milk fever, Downer cow syndrome, Vaginal prolapse, post-partum hemoglobinuria\n*Dosage:* Cattle 10-25ml by Intravenous, subcutaneously & intramuscularly route";
                                $reply_message .= "\n\nType *0* to go back one step\nType *99* to go back home";
                                Log::info("Order 10 bot response: " . $reply_message);

                                //save user start response step
                                $client = User::where('phoneNumber', $user_identifier)->first();
                                $user_steps = new UserSessionStep();
                                $user_steps->message = $message;
                                $user_steps->botSessionStep = $reply_message;
                                $client->steps()->save($user_steps);

                                if ($channel == env('WHATSAPP_CHANNEL')) {

                                    if (env('WA_BOT_ENV') == 'TWILIO') {
                                        // TWILIO API CREDENTIALS
                                        $sid = 'AC86868678f517b851d044e933039b8a1c';
                                        $token = '3e5c1042b1c7d6a6e6717e7d9818f38c'; 

                                        // The TujengePay WhatsApp number
                                        $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                        // Initialize the Twilio Client
                                        $twilio = new \Twilio\Rest\Client($sid, $token);

                                        $message = $twilio->messages
                                            ->create(
                                                "whatsapp:" . $user_identifier,
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
                            } else if ($message == 11) {
                                $reply_message = "*Animatic super Ndama*\nIt’s a specially formulated diet for feeding calves from Day 4 after birth with 70% milk products, Vitamins and minerals for optimum growth and better calf immunity.\n*Dosage and feeding recommendation:*\n• Add 1 to 1.25kg of animatic milk replacer to 10litres of warm water (100-125g/liter)";
                                $reply_message .= "\n\nType *0* to go back one step\nType *99* to go back home";
                                Log::info("Order 11 bot response: " . $reply_message);

                                //save user start response step
                                $client = User::where('phoneNumber', $user_identifier)->first();
                                $user_steps = new UserSessionStep();
                                $user_steps->message = $message;
                                $user_steps->botSessionStep = $reply_message;
                                $client->steps()->save($user_steps);
                                if ($channel == env('WHATSAPP_CHANNEL')) {

                                    if (env('WA_BOT_ENV') == 'TWILIO') {
                                        // TWILIO API CREDENTIALS
                                        $sid = 'AC86868678f517b851d044e933039b8a1c';
                                        $token = '3e5c1042b1c7d6a6e6717e7d9818f38c'; 

                                        // The TujengePay WhatsApp number
                                        $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                        // Initialize the Twilio Client
                                        $twilio = new \Twilio\Rest\Client($sid, $token);

                                        $message = $twilio->messages
                                            ->create(
                                                "whatsapp:" . $user_identifier,
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
                            } else if ($message == 0) {
                                $next_bot_step = $active_session_step->bot_session_step;
                            }
                        }

                        if ($service_method->method_type == 'get_product') {

                            if ($message == '0') {

                                $next_bot_step = $active_session_step->bot_session_step;
                            } else {
                                $data = Disease::latest()->first();
                                $crops = Crop::where('id', $data->crop_id)->get();
                                $diseases = Product::where('crop_number', $message)
                                    ->where('crop_id', $data->crop_id)
                                    ->get();

                                Log::info('Disease Information' . $diseases);

                                if ($diseases->count() == 0) {

                                    $reply_message = "Thank you for being our valued\ncustomer.🙂👍🏽\n\nReply with *99* to exit.";
                                    Log::info("Product bot response: " . $reply_message);
                                } else {
                                    $reply_message = "";

                                    foreach ($diseases as $disease) {
                                        foreach ($crops as $crop) {
                                            Log::info("Crop Etag: " . $crop->etag);
                                            $products = OshoProduct::where('tcc_crop', $crop->etag)
                                                ->where('tcc_targetpest', $disease->disease)->get();
                                            foreach ($products as $product) {
                                                Log::info("Product: " . $product->tcc_product);
                                                $reply_message .= $product->tcc_targetpest . ", use\n" . $product->tcc_product . "\n\n";
                                            }
                                        }
                                    }
                                }
                                // $reply_message .= "Do you want to continue ?\n\n1 Yes\n2 No";
                                Log::info("Product bot response: " . $reply_message);

                                //save user start response step
                                $client = User::where('phoneNumber', $user_identifier)->first();
                                $user_steps = new UserSessionStep();
                                $user_steps->message = $message;
                                $user_steps->botSessionStep = $reply_message;
                                $client->steps()->save($user_steps);

                                if ($channel == env('WHATSAPP_CHANNEL')) {

                                    if (env('WA_BOT_ENV') == 'TWILIO') {
                                        // TWILIO API CREDENTIALS
                                        $sid = 'AC86868678f517b851d044e933039b8a1c';
                                        $token = '3e5c1042b1c7d6a6e6717e7d9818f38c'; 

                                        // The TujengePay WhatsApp number
                                        $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                                        // Initialize the Twilio Client
                                        $twilio = new \Twilio\Rest\Client($sid, $token);

                                        $message = $twilio->messages
                                            ->create(
                                                "whatsapp:" . $user_identifier,
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
                            }
                        }
                        if ($service_method->method_type == 'registration') {

                            Log::info("START REGISTRATION");
                            $countys = County::where('id', $message)->get();
                            Log::info("User County info: " . $countys);
                            foreach ($countys as $count) {
                                Log::info("User County: " . $count->name);
                                $users = WhatsappAccount::where('phone_number', $user_identifier)->get();
                                Log::info("User: " . $users);
                                foreach ($users as $user) {
                                    Log::info("Save County");
                                    $user->county = $count->name;
                                    $user->save();
                                    Log::info("County saved successfully");
                                }
                            }
                            $reply_message = " ";
                            $next_bot_step = $botSessionService->getNextBotStep($channel, $active_session_step->bot_session_step, $message);
                        }
                        if ($service_method->method_type == 'get_start') {
                            Log::info("Get start session");
                            $reply_message = " ";
                            $next_bot_session = $botSessionService->getNextBotSession($channel, $message, new BotSessionRepository());

                            $session = $botSessionService->processSession(
                                $user_identifier,
                                $channel,
                                $bot_account,
                                $next_bot_session,
                                new WhatsappSessionRepository()
                            );

                            $bot_session = $next_bot_session;

                            Log::info('NBS' . $next_bot_session->session_key_word);

                            $next_bot_step = $botSessionService->getZeroBotSessionStep($channel, $next_bot_session, new BotSessionRepository());

                            Log::info('NS' . $next_bot_step->session_step_key);
                        }
                    }

                    $botSessionService->deactivateBotSessionSteps(
                        $channel,
                        $user_identifier,
                        $bot_account,
                        new WhatsappSessionRepository()
                    );

                    $botSessionService->setSessionStep(
                        $session,
                        $channel,
                        $user_identifier,
                        $message,
                        $bot_account,
                        $next_bot_step,
                        new WhatsappSessionRepository()
                    );

                    //                    return 'ok';
                }

                $bot_responses = $botSessionService->getBotResponses($message, $channel, $bot_session, $next_bot_step, $active_session_step->bot_session_step);
                $reply_message = $next_bot_step->step_title;
                $word = "profilename";
                $mystring = $next_bot_step->step_title;

                // Test if string contains the word
                if (strpos($mystring, $word) !== false) {
                    Log::info("Word Found: " . $mystring);
                    $reply_message = str_replace("profilename", $profile_name, $mystring);
                    Log::info("Replaced reply message: " . $reply_message);
                }


                foreach ($bot_responses as $bot_response) {

                    $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
                }

                //get user steps from user journey
                //check if the string is empty. If it is empty the bot response comes from services
                if (str_word_count($reply_message) > 0) {
                    Log::info("Bot responses: " . $reply_message);
                    //save user start response step
                    $client = User::where('phoneNumber', $user_identifier)->first();
                    $user_steps = new UserSessionStep();
                    $user_steps->message = $message;
                    $user_steps->botSessionStep = $reply_message;
                    $client->steps()->save($user_steps);
                }

                if ($channel == env('WHATSAPP_CHANNEL')) {

                    if (env('WA_BOT_ENV') == 'TWILIO') {
                        // TWILIO API CREDENTIALS
                        $sid = 'AC86868678f517b851d044e933039b8a1c';
                        $token = '3e5c1042b1c7d6a6e6717e7d9818f38c'; 

                        // The TujengePay WhatsApp number
                        $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                        // Initialize the Twilio Client
                        $twilio = new \Twilio\Rest\Client($sid, $token);

                        $message = $twilio->messages
                            ->create(
                                "whatsapp:" . $user_identifier,
                                array(
                                    "body" => $reply_message,
                                    "from" => "whatsapp:" . $whatsapp_live_number
                                )
                            );
                    }

                    if ($reply_message != "") {

                        if (env('WA_BOT_ENV') == '360') {


                            if ($next_bot_step->reply_type == 'inline_buttons') {


                                foreach ($bot_responses as $bot_response) {

                                    $force_text = "";

                                    if ($bot_response->image_url != "") {
                                        if ($next_bot_step->button_header_type == 'image') {

                                            $headers = [
                                                "type" => "image",
                                                "image" => [
                                                    "link" => $bot_response->image_url,
                                                ]
                                            ];


                                            $buttons[] = [
                                                "type" => "reply",
                                                "reply" => [
                                                    "id" => $bot_response->key_word,
                                                    "title" => 'Get an Agrovet'
                                                ]
                                            ];

                                            $interactive = [
                                                "type" => "button",
                                                "header" => $headers,
                                                "body" => [
                                                    "text" => $bot_response->response_text == '' ? 'Pick an item below' : $bot_response->response_text
                                                ],
                                                "action" => [
                                                    'buttons' => $buttons
                                                ] # end action
                                            ];

                                            $buttons = [];
                                        }
                                    } else {

                                        $force_text = 'text';
                                    }


                                    if ($next_bot_step->button_header_type == 'text' || $force_text == 'text') {

                                        $buttons[] = [
                                            "type" => "reply",
                                            "reply" => [
                                                "id" => $bot_response->key_word,
                                                "title" =>  $force_text != 'text' ? 'Get an Agrovet' : 'Click here'
                                            ]
                                        ];

                                        $interactive = [
                                            "type" => "button",
                                            "body" => [
                                                "text" => $bot_response->response_text == '' ? 'Pick an item below' : $bot_response->response_text
                                            ],
                                            "action" => [
                                                'buttons' => $buttons
                                            ] # end action
                                        ];

                                        $buttons = [];
                                    }

                                    $whatsAppServiceApi->sendInteractiveButton($message_from, $interactive);
                                }
                            } else {
                                $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                            }
                        }
                    }
                }


                $botSessionService->deactivateBotSessionSteps(
                    $channel,
                    $user_identifier,
                    $bot_account,
                    new WhatsappSessionRepository()
                );

                $botSessionService->setSessionStep(
                    $session,
                    $channel,
                    $user_identifier,
                    $message,
                    $bot_account,
                    $next_bot_step,
                    new WhatsappSessionRepository()
                );

                return 'ok';
            }
        } else {

            // Create a new bot account
            $created_bot_account = $botAccountsService->storeAccount(
                $user_identifier,
                $channel,
                new WhatsappAccountRepository()
            );

            $bot_responses = $this->getStartSession($botSessionService, $user_identifier, $channel, $created_bot_account, $message, $profile_name);

            $reply_message = $bot_responses['bot_step']->step_title;

            foreach ($bot_responses['bot_responses'] as $bot_response) {

                $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
            }

            Log::info("Start Session Reply Message 2: " . $reply_message);
            //save user start response step
            $client = User::where('phoneNumber', $user_identifier)->first();
            $user_steps = new UserSessionStep();
            $user_steps->message = $message;
            $user_steps->botSessionStep = $reply_message;
            $client->steps()->save($user_steps);

            if ($channel == env('WHATSAPP_CHANNEL')) {

                if (env('WA_BOT_ENV') == 'TWILIO') {
                    // TWILIO API CREDENTIALS
                    $sid = 'AC86868678f517b851d044e933039b8a1c';
                    $token = '3e5c1042b1c7d6a6e6717e7d9818f38c'; 

                    // The TujengePay WhatsApp number
                    $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                    // Initialize the Twilio Client
                    $twilio = new \Twilio\Rest\Client($sid, $token);

                    $message = $twilio->messages
                        ->create(
                            "whatsapp:" . $user_identifier,
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
        }

        return 'ok';
    }


    //

    //
    public function getStartSession(BotSessionService $botSessionService, $user_identifier, $channel, $created_bot_account, $message, $profile_name)
    {
        // Get Initiate Session
        $bot_session = $botSessionService->getBotSession($channel, '99');

        // Process the bot session
        $session = $botSessionService->processSession(
            $user_identifier,
            $channel,
            $created_bot_account,
            $bot_session,
            new WhatsappSessionRepository()
        );

        $whatsappSessionRepository = new WhatsappSessionRepository();

        //Process the bot session step
        $bot_step = $botSessionService->getBotStep($message, $channel, $bot_session);

        // Get the session step
        $botSessionService->setSessionStep(
            $session,
            $channel,
            $user_identifier,
            $message,
            $created_bot_account,
            $bot_step,
            new WhatsappSessionRepository()
        );

        // Get bot output response using user key word, channel and session
        $bot_responses = $botSessionService->getBotResponses($message, $channel, $bot_session, $bot_step, $bot_step);

        //save user info
        $client = User::where('phoneNumber', $user_identifier)->first();
        if ($client == null) {
            $user = new User();
            $user->phoneNumber = $user_identifier;
            $user->userName = $profile_name;
            $user->save();
        }
        Log::info("Start Bot Response: " . $bot_responses);
        Log::info("Start Bot Step: " . $bot_step);

        //save user start response step
        // $client = User::where('phoneNumber', $user_identifier)->first();
        // $user_steps = new UserSessionStep();
        // $user_steps->message = $message;
        // $user_steps->botSessionStep = $bot_step;
        // $client->steps()->save($user_steps);
        return [
            'bot_step' => $bot_step,
            'bot_responses' => $bot_responses
        ];
    }

    //

    //
    public
    function getSession(BotSessionService $botSessionService, $user_identifier, $channel, $created_bot_account, $message, $profile_name)
    {
        // Get Initiate Session
        $bot_session = $botSessionService->getBotSession($channel, $message);

        Log::info('Session Name : ' . $bot_session->session_name);



        // Process the bot session
        $session = $botSessionService->processSession(
            $user_identifier,
            $channel,
            $created_bot_account,
            $bot_session,
            new WhatsappSessionRepository()
        );

        //Process the bot session step
        $bot_step = $botSessionService->getInitialBotStep($message, $channel, $bot_session);

        // Get the session step
        $botSessionService->setSessionStep(
            $session,
            $channel,
            $user_identifier,
            $message,
            $created_bot_account,
            $bot_step,
            new WhatsappSessionRepository()
        );

        // Get bot output response using user key word, channel and session
        $bot_responses = $botSessionService->getBotResponses($message, $channel, $bot_session, $bot_step, $bot_step);

        Log::info('Another Session: ' . $bot_responses);

        //save user info
        $client = User::where('phoneNumber', $user_identifier)->first();
        if ($client == null) {
            $user = new User();
            $user->phoneNumber = $user_identifier;
            $user->userName = $profile_name;
            $user->save();
        }
        //save user start response step
        // $client = User::where('phoneNumber', $user_identifier)->first();
        // $user_steps = new UserSessionStep();
        // $user_steps->message = $message;
        // $user_steps->botSessionStep = $bot_step;
        // $client->steps()->save($user_steps);
        return [
            'bot_step' => $bot_step,
            'bot_responses' => $bot_responses
        ];
    }

    //

    //
    public
    function messengerUpdates(
        BotAccountsService $botAccountsService,
        BotSessionService $botSessionService,
        WhatsappSessionRepository $whatsappSessionRepository,
        BotSessionRepository $botSessionRepository,
        BotServices $botServices,
        WhatsAppServiceApi $whatsAppServiceApi
    ) {

        $input = json_decode(file_get_contents('php://input'), true);

        // Get the Senders Graph ID
        $sender = $input['entry'][0]['messaging'][0]['sender']['id'];

        // Get the returned message
        $message = $input['entry'][0]['messaging'][0]['message']['text'];

        $channel = env('MESSENGER_CHANNEL');

        Log::info('ME ' . $message);

        $this->startEngine(
            $botAccountsService,
            $sender,
            $channel,
            $botSessionService,
            $message,
            $whatsappSessionRepository,
            $botSessionRepository,
            $botServices,
            $whatsAppServiceApi
        );
    }

    //

    //
    public
    function botUpdates(
        Request $request,
        BotAccountsService $botAccountsService,
        BotSessionService $botSessionService,
        WhatsappSessionRepository $whatsappSessionRepository,
        BotSessionRepository $botSessionRepository,
        BotServices $botServices,
        WhatsAppServiceApi $whatsAppServiceApi
    ) {

        $message = $request->message;

        $update_id = $request->update_id;

        Log::info('Update Id : ' . $request->update_id);

        $from = $message['from'];

        $from_id = $from['id'];

        $is_bot = $from['is_bot'];

        $first_name = $from['first_name'];

        $last_name = $from['last_name'];

        $user_name = $from['username'];

        $language_code = $from['language_code'];

        $chat = $message['chat'];

        $chat_id = $chat['id'];

        $chat_first_name = $chat['first_name'];

        $chat_last_name = $chat['last_name'];

        $chat_username = $chat['username'];

        $chat_type = $chat['type'];

        $message_date = $message['date'];

        $message_text = $message['text'];

        $channel = env('TELEGRAM_CHANNEL');

        Log::info('Update Id : ' . $request->update_id);
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

        $this->startEngine(
            $botAccountsService,
            $chat_id,
            $channel,
            $botSessionService,
            $message_text,
            $whatsappSessionRepository,
            $botSessionRepository,
            $botServices,
            $whatsAppServiceApi
        );
    }

    //

    public
    function replyToWhatsApp()
    {
    }
}
