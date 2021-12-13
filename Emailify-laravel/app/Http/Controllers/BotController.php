<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Services\BotSessionService;
use Illuminate\Support\Facades\Log;
use App\Services\BotAccountsService;
use App\Services\WhatsAppServiceApi;
use App\Repositories\BotSessionRepository;
use App\Repositories\WhatsappAccountRepository;
use App\Repositories\WhatsappSessionRepository;

class BotController extends Controller
{
    public function botEngine(
        Request $request,
        BotAccountsService $botAccountsService,
        BotSessionService $botSessionService,
        WhatsappSessionRepository $whatsappSessionRepository,
        BotSessionRepository $botSessionRepository,
        WhatsAppServiceApi $whatsAppServiceApi
    ) {

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

        Log::info('Body : ' . $body);

        $channel = 'WA'; //$request->channel;
        $user_identifier = $whatsapp_number;
        $message = $body;

        $this->startEngine(
            $botAccountsService,
            $user_identifier,
            $channel,
            $botSessionService,
            $message,
            $whatsappSessionRepository,
            $botSessionRepository,
            $whatsAppServiceApi
        );
    }

    public function startEngine(
        BotAccountsService $botAccountsService,
        $user_identifier,
        $channel,
        BotSessionService $botSessionService,
        $message,
        WhatsappSessionRepository $whatsappSessionRepository,
        BotSessionRepository $botSessionRepository,
        WhatsAppServiceApi $whatsAppServiceApi
    ) {

        // Get Account From Channel and userIdentifier
        $bot_account = $botAccountsService->getAccount(
            $user_identifier,
            $channel,
            new WhatsappAccountRepository()
        );


        if (!is_null($bot_account)) {

            // check if session keyword
            if ($botSessionService->checkIfSessionExistsByName($channel, $message, new BotSessionRepository())) {

                Log::info('uid' . $user_identifier);

                $botSessionService->deactivateBotSession(
                    $channel,
                    $user_identifier,
                    $whatsappSessionRepository,
                );

                $bot_responses = $this->getSession($botSessionService, $user_identifier, $channel, $bot_account, $message);

                $reply_message = $bot_responses['bot_step']->step_title;

                foreach ($bot_responses['bot_responses'] as $bot_response) {

                    $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
                }

                if ($channel == env('WHATSAPP_CHANNEL')) {

                    // TWILIO API CREDENTIALS
                    $sid = 'AC86868678f517b851d044e933039b8a1c';
                    $token = '3e5c1042b1c7d6a6e6717e7d9818f38c';

                    // The TujengePay WhatsApp number
                    $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                    // Initialize the Twilio Client
                    $twilio = new Client('AC86868678f517b851d044e933039b8a1c', '3e5c1042b1c7d6a6e6717e7d9818f38c');

                    $message = $twilio->messages
                        ->create(
                            "whatsapp:" . $user_identifier,
                            array(
                                "body" => $reply_message,
                                "from" => "whatsapp:" . $whatsapp_live_number
                            )
                        );
                }

                return 'ok';
            }

            $active_session = $botSessionService->checkForActiveSession(
                $bot_account,
                $channel,
                new WhatsappSessionRepository()
            );

            Log::info('AS');

            if ($active_session) {

                Log::info('AS1');


                $active_session_step = $botSessionService->getActiveBotStep(
                    $bot_account,
                    $channel,
                    new WhatsappSessionRepository()
                );

                $session = $botSessionService->getActiveSession(
                    $channel,
                    $user_identifier,
                    new WhatsappSessionRepository()
                );

                Log::info('res exists');

                $bot_session = $session->bot_session;

                Log::info('ASST ID ' . $active_session_step->id);

                if ($active_session_step->bot_session_step->is_initial_step && $bot_session->session_key_word == 0) {

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
                } else {

                    $next_bot_step = $botSessionService->getNextBotStep($channel, $active_session_step->bot_session_step, $message);
                }

                //service
                if ($active_session_step->bot_session_step->service_methods != null) {

                    $service_methods = (array)json_decode($active_session_step->bot_session_step->service_methods);

                    foreach ($service_methods as $service_method) {
                        //method_type

                    }
                }

                $bot_responses = $botSessionService->getBotResponses($message, $channel, $bot_session, $next_bot_step);

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

                $reply_message = $next_bot_step->step_title;

                foreach ($bot_responses as $bot_response) {

                    $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
                }

                if ($channel == env('WHATSAPP_CHANNEL')) {

                    // TWILIO API CREDENTIALS
                    $sid = 'AC86868678f517b851d044e933039b8a1c';
                    $token = '3e5c1042b1c7d6a6e6717e7d9818f38c';

                    // The TujengePay WhatsApp number
                    $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                    // Initialize the Twilio Client
                    $twilio = new Client($sid, $token);

                    $message = $twilio->messages
                        ->create(
                            "whatsapp:" . $user_identifier,
                            array(
                                "body" => $reply_message,
                                "from" => "whatsapp:" . $whatsapp_live_number
                            )
                        );
                }

                return 'ok';
            }
        } else {

            // Create a new bot account
            $created_bot_account = $botAccountsService->storeAccount(
                $user_identifier,
                $channel,
                new WhatsappAccountRepository()
            );

            $bot_responses = $this->getStartSession($botSessionService, $user_identifier, $channel, $created_bot_account, $message);

            $reply_message = $bot_responses['bot_step']->step_title;

            foreach ($bot_responses['bot_responses'] as $bot_response) {

                $reply_message .= $bot_response->show_step_id == true ? $bot_response->key_word . " " . $bot_response->response_text . "\n" : $bot_response->response_text . "\n";
            }

            if ($channel == env('WHATSAPP_CHANNEL')) {

                // TWILIO API CREDENTIALS
                $sid = 'AC86868678f517b851d044e933039b8a1c';
                $token = '3e5c1042b1c7d6a6e6717e7d9818f38c';

                // The TujengePay WhatsApp number
                $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                // Initialize the Twilio Client
                $twilio = new Client($sid, $token);

                $message = $twilio->messages
                    ->create(
                        "whatsapp:" . $user_identifier,
                        array(
                            "body" => $reply_message,
                            "from" => "whatsapp:" . $whatsapp_live_number
                        )
                    );
            }
        }

        return 'ok';
    }

    public function getStartSession(BotSessionService $botSessionService, $user_identifier, $channel, $created_bot_account, $message)
    {
        // Get Initiate Session
        $bot_session = $botSessionService->getBotSession($channel, 'hi');

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
        $bot_responses = $botSessionService->getBotResponses($message, $channel, $bot_session, $bot_step);

        Log::info('MESSENGER');

        return [
            'bot_step' => $bot_step,
            'bot_responses' => $bot_responses
        ];
    }

    public function messengerUpdates(
        BotAccountsService $botAccountsService,
        BotSessionService $botSessionService,
        WhatsappSessionRepository $whatsappSessionRepository,
        BotSessionRepository $botSessionRepository,
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
            $whatsAppServiceApi
        );
    }

    public function botUpdates(
        Request $request,
        BotAccountsService $botAccountsService,
        BotSessionService $botSessionService,
        WhatsappSessionRepository $whatsappSessionRepository,
        BotSessionRepository $botSessionRepository,
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
            $whatsAppServiceApi
        );
    }
}
