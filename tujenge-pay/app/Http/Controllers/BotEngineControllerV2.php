<?php

namespace App\Http\Controllers;

use App\Models\BotSessionStep;
use App\Models\WhatsappOtpCode;
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
use App\Services\Emoji;
use App\Services\WhatsAppServiceApi;
use App\UniqueWhatsappMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Integer;
use Telegram\Bot\Api;

class BotEngineControllerV2 extends Controller
{
    public function botEngine(Request $request,
                              BotAccountsService $botAccountsService,
                              BotSessionService $botSessionService,
                              WhatsappSessionRepository $whatsappSessionRepository,
                              BotSessionRepository $botSessionRepository,
                              BotServices $botServices,
                              WhatsAppServiceApi $whatsAppServiceApi)
    {

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

        $profile_name = isset($device['profile_name']) ? $device['profile_name'] : 'n/a';

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

        $this->startEngine($botAccountsService,
            $user_identifier,
            $channel,
            $botSessionService,
            $message,
            $whatsappSessionRepository,
            $botSessionRepository,
            $botServices,
            $whatsAppServiceApi,
            $message_from
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
                                $message_from)
    {

        // Get Account From Channel and userIdentifier
        $bot_account = $botAccountsService->getAccount($user_identifier,
            $channel,
            new WhatsappAccountRepository(),
            new TelegramAccountRepository(),
            new MessengerAccountRepository());

        if (!is_null($bot_account)) {

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

                foreach ($bot_responses['bot_responses'] as $bot_response) {

                    $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
                }

                if ($channel == env('WHATSAPP_CHANNEL')) {

                    $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                }

                if ($channel == env('TELEGRAM_CHANNEL')) {

                    $telegram = new Api(env('TELEGRAM_TOKEN'));

                    $response = $telegram->sendMessage([
                        'chat_id' => $user_identifier,
                        'text' => $reply_message
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

            if ($active_session) {


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

                Log::info('res exists');

                $bot_session = $session->bot_session;

                Log::info('ASST ID ' . $active_session_step->id);

                if ($active_session_step->bot_session_step->is_initial_step && $bot_session->session_key_word == 0) {

                    $next_bot_session = $botSessionService->getNextBotSession($channel, $message, new BotSessionRepository());

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

                    $next_bot_step = $botSessionService->getNextBotStep($channel, $active_session_step->bot_session_step, $message);

                }


//                if ((int) $body == 0) {
//
//                    Log::info('Body is 0'. $body);
//
//                    $next_bot_step = BotSessionStep::where('session_step_key', 2)->where('bot_session_id', $session->bot_session_id)->first();
//
//                }else{
//                    $next_bot_step = $botSessionService->getNextBotStep($channel, $active_session_step->bot_session_step, $message);
//                }

                if ($active_session_step->bot_session_step->service_methods != null) {

                    $service_methods = (array)json_decode($active_session_step->bot_session_step->service_methods);

                    foreach ($service_methods as $service_method) {

                        if ($service_method->method_type == 'validate') {
                            $validation_results = $botServices->{$service_method->method_name}($message);

                            if ($validation_results == false) {

                                $reply_message = 'You have entered an invalid input, please try again';

                                if ($channel == env('WHATSAPP_CHANNEL')) {

                                    $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                                }

                                if ($channel == env('TELEGRAM_CHANNEL')) {

                                    $telegram = new Api(env('TELEGRAM_TOKEN'));

                                    $response = $telegram->sendMessage([
                                        'chat_id' => $user_identifier,
                                        'text' => $reply_message
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

                            $opt_confirmation_status = $botServices->{$service_method->method_name}($user_identifier, $message);

                            if ($opt_confirmation_status == false) {

                                $reply_message = 'You have entered an invalid OTP, please try again';

                                if ($channel == env('WHATSAPP_CHANNEL')) {

                                    $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                                }

                                if ($channel == env('TELEGRAM_CHANNEL')) {

                                    $telegram = new Api(env('TELEGRAM_TOKEN'));

                                    $response = $telegram->sendMessage([
                                        'chat_id' => $user_identifier,
                                        'text' => $reply_message
                                    ]);
                                }

                                return 'ok';
                            }
                        }

                        if ($service_method->method_type == 'query_balance') {

                            Log::info('QUERY BALANCE');

                            $reply_message = $botServices->{$service_method->method_name}($user_identifier, $channel, 'query_balance');

                            if ($channel == env('WHATSAPP_CHANNEL')) {

                                $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                            }

                            if ($channel == env('TELEGRAM_CHANNEL')) {

                                $telegram = new Api(env('TELEGRAM_TOKEN'));

                                $response = $telegram->sendMessage([
                                    'chat_id' => $user_identifier,
                                    'text' => $reply_message
                                ]);
                            }

                            return 'ok';
                        }

                        if ($service_method->method_type == 'query_cover') {

                            Log::info('QUERY COVER');

                            $reply_message = $botServices->{$service_method->method_name}($user_identifier, $channel, 'query_cover');

                            if ($channel == env('WHATSAPP_CHANNEL')) {
                                $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                            }

                            if ($channel == env('TELEGRAM_CHANNEL')) {

                                $telegram = new Api(env('TELEGRAM_TOKEN'));

                                $response = $telegram->sendMessage([
                                    'chat_id' => $user_identifier,
                                    'text' => $reply_message
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
////Initiate cURL.
//                                $ch = curl_init($url);
//
//
////The JSON data.
//                                $jsonData = '{
//    "recipient":{
//        "id":"' . $user_identifier . '"
//    },
//    "message":{
//        "text": "'.$reply_message.'"
//    }
//}';
//
////Tell cURL that we want to send a POST request.
//                                curl_setopt($ch, CURLOPT_POST, 1);
//
////Attach our encoded JSON string to the POST fields.
//                                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
//
////Set the content type to application/json
//                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//
////Execute the request but first check if the message is not empty.
////                                if (!empty($input['entry'][0]['messaging'][0]['message'])) {
//                                    $result = curl_exec($ch);
////                                }


                            }

                            return 'ok';
                        }

                        if ($service_method->method_type == 'query_utilization') {

                            Log::info('QUERY UTILIZATION');

                            $reply_message = $botServices->{$service_method->method_name}($user_identifier, $channel, 'query_utilization');

                            if ($channel == env('WHATSAPP_CHANNEL')) {
                                $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                            }

                            if ($channel == env('TELEGRAM_CHANNEL')) {

                                $telegram = new Api(env('TELEGRAM_TOKEN'));

                                $response = $telegram->sendMessage([
                                    'chat_id' => $user_identifier,
                                    'text' => $reply_message
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
////Initiate cURL.
//                                $ch = curl_init($url);
//
//
////The JSON data.
//                                $jsonData = '{
//    "recipient":{
//        "id":"' . $user_identifier . '"
//    },
//    "message":{
//        "text": "'.$reply_message.'"
//    }
//}';
//
////Tell cURL that we want to send a POST request.
//                                curl_setopt($ch, CURLOPT_POST, 1);
//
////Attach our encoded JSON string to the POST fields.
//                                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
//
////Set the content type to application/json
//                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//
////Execute the request but first check if the message is not empty.
////                                if (!empty($input['entry'][0]['messaging'][0]['message'])) {
//                                    $result = curl_exec($ch);
////                                }


                            }

                            return 'ok';
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

                                    $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                                }

                                if ($channel == env('TELEGRAM_CHANNEL')) {

                                    $telegram = new Api(env('TELEGRAM_TOKEN'));

                                    $response = $telegram->sendMessage([
                                        'chat_id' => $user_identifier,
                                        'text' => $reply_message
                                    ]);
                                }

                                return 'ok';

                            }
                        }

                        if ($service_method->method_type == 'membership_check') {

                            Log::info('CHECK USER MEMBERSHIP');

                            $result = $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'membership_check');

                            Log::info('RESULT INFO ' . $result);

                            if ($result == true) {

                                Log::info('MT : OTP');

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

//                        if($service_method->method_type == 'calculate_premium'){
//
//                            Log::info('CALCULATE PREMIUM');
//
////                            $result = $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'calculate_premium');
//                        }

//                        if($service_method->method_type == 'make_payment'){
//
//                            Log::info('MAKE PAYMENT');
//
//                            $result = $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'make_payment');
//                        }

                        if ($service_method->method_type == 'check_mpesa_number') {

                            Log::info('Check Mpesa Number');

//                            $result = $botServices->{$service_method->method_name}($user_identifier, $channel, $message, 'check_mpesa_number');

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

                            if ($channel == env('WHATSAPP_CHANNEL')) {

                                $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);

                            }

                            return 'ok';
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

//                $whatsappSessionRepository->deactivateWhatsappSessionStep($user_identifier, $channel, $bot_account);

                $botSessionService->setSessionStep($session,
                    $channel,
                    $user_identifier,
                    $message,
                    $bot_account,
                    $next_bot_step,
                    new WhatsappSessionRepository(),
                    new TelegramSessionRepository(),
                    new MessengerSessionRepository());

                $reply_message = $next_bot_step->step_title;

                foreach ($bot_responses as $bot_response) {

                    $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
                }

                if($next_bot_step->response_source == 'function'){

                    if ($next_bot_step->response_function == 'queryPolicyStatement') {

                        Log::info('QUERY POLICY STATEMENT');

                        $reply_message = $botServices->{$next_bot_step->response_function}($user_identifier, $message, 'query_policy_statement', $channel);
                    }elseif ($next_bot_step->response_function == 'queryUtilization'){
                        $reply_message = $botServices->{$next_bot_step->response_function}($user_identifier, $channel, 'query_utilization');
                    }elseif ($next_bot_step->response_function == 'queryCover'){
                        $reply_message = $botServices->{$next_bot_step->response_function}($user_identifier, $channel, 'query_cover');
                    }elseif ($next_bot_step->response_function == 'queryBalances'){
                        $reply_message = $botServices->{$next_bot_step->response_function}($user_identifier, $channel, 'query_balance');
                    }else{

                        $reply_message = $botServices->{$next_bot_step->response_function}($user_identifier, $channel);
                    }
                }

//                $reply_message .= "\nSend 0 to go back home";

                if ($channel == env('WHATSAPP_CHANNEL')) {

                    $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
                }

                if ($channel == env('TELEGRAM_CHANNEL')) {

                    $telegram = new Api(env('TELEGRAM_TOKEN'));

                    $response = $telegram->sendMessage([
                        'chat_id' => $user_identifier,
                        'text' => $reply_message
                    ]);
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

            foreach ($bot_responses['bot_responses'] as $bot_response) {

                $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
            }

            if ($channel == env('WHATSAPP_CHANNEL')) {

                $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
            }

            if ($channel == env('TELEGRAM_CHANNEL')) {

                $telegram = new Api(env('TELEGRAM_TOKEN'));

                $response = $telegram->sendMessage([
                    'chat_id' => $user_identifier,
                    'text' => $reply_message
                ]);
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

        return [
            'bot_step' => $bot_step,
            'bot_responses' => $bot_responses
        ];
    }

    public function messengerUpdates()
    {

        $challenge = $_REQUEST['hub_challenge'];
        $verify_token = $_REQUEST['hub_verify_token'];

// Set this Verify Token Value on your Facebook App
        if ($verify_token === '*jayjay123#') {
            echo $challenge;
        }

        $input = json_decode(file_get_contents('php://input'), true);

// Get the Senders Graph ID
        $sender = $input['entry'][0]['messaging'][0]['sender']['id'];

// Get the returned message
        $message = $input['entry'][0]['messaging'][0]['message']['text'];

//API Url and Access Token, generate this token value on your Facebook App Page
        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg';

//Initiate cURL.
        $ch = curl_init($url);

//The JSON data.
        $jsonData = '{
    "recipient":{
        "id":"' . $sender . '"
    },
    "message":{
        "text":"Hellow world"
    }
}';

//Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

//Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

//Execute the request but first check if the message is not empty.
        if (!empty($input['entry'][0]['messaging'][0]['message'])) {
            $result = curl_exec($ch);
        }
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

//        dd($message_text);

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

        $this->startEngine($botAccountsService,
            $chat_id,
            $channel,
            $botSessionService,
            $message_text,
            $whatsappSessionRepository,
            $botSessionRepository,
            $botServices,
            $whatsAppServiceApi,
            $from
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
