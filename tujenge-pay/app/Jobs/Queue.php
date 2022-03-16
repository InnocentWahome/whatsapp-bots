<?php

namespace App\Jobs;

use App\Services\WhatsAppServiceApi;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;

class Queue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $body;
    protected $channel;
    protected $whatsapp_number;
    protected $message_type;
    protected $message_from;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($body, $channel, $whatsapp_number, $message_type)
    {
        $this->body = $body;
        $this->channel = $channel;
        $this->whatsapp_number = $whatsapp_number;
        $this->message_type = $message_type;
        $this->message_from = substr($whatsapp_number, 1);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();

        $whatsAppServiceApi = new WhatsAppServiceApi();

        if ($this->message_type == 'query_policy_statement') {

            $response = $client->request('POST', env('QUERY_POLICY_STATEMENT_URL'), [
                'timeout' => 45, // Response timeout
                'connect_timeout' => 30, // Connection timeout
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => $this->body
            ]);

            $array_response = (array)json_decode($response->getBody());

            $results = $array_response['result'];

            $reply_message = "*Here is your premium statement*\n\n";

            if($results->main_member != 'N/A'){

                //        $members = $results->members;
                $main_member = $results->main_member;
                $premium = $results->premium;
                $credits = $results->credits;

                $reply_message .= "Name : " . $main_member->MEMBER_NAME . "\n";
                $reply_message .= "Member No : " . $main_member->DISPLAY_MEMBERSHIP_NO . "\n\n";

//        $reply_message .= "Other Members\n\n";

//        foreach ($members as $member) {
//
//            $reply_message .= "Name " . $member->PROPOSER_DISPLAY_NAME . "\n\n";
//        }

                $reply_message .= "Premium Details\n\n";

                $reply_message .= "Amount KES " . $premium->PREMIUM . "\n\n";

                $reply_message .= "Credits\n\n";

                foreach ($credits as $credit) {

                    $reply_message .= "Amount " . $credit->REC_AMOUNT . "\n\n";
                }
            }

//        $reply_message .= "From : " . $premium->PERIOD_FROM . "\n";
//        $reply_message .= "To : " . $premium->PERIOD_TO . "\n";

            $reply_message .= "\nThere you go!! 🙂 ... Please reply with *AAR* to go back to the main menu.";

            if ($this->channel == env('WHATSAPP_CHANNEL')) {

                if(env('WA_BOT_ENV') == 'TWILIO'){
               wq     // TWILIO API CREDENTIALS
                    $sid = env('TWILIO_SID');
                    $token = env('TWILIO_TOKEN');

                    // The TujengePay WhatsApp number
                    $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                    // Initialize the Twilio Client
                    $twilio = new \Twilio\Rest\Client($sid, $token);

                    $message = $twilio->messages
                        ->create("whatsapp:" . $this->whatsapp_number,
                            array(
                                "body" => $reply_message,
                                "from" => "whatsapp:" . $whatsapp_live_number
                            )
                        );
                }

                if(env('WA_BOT_ENV') == '360'){

                    $whatsAppServiceApi->send('text', $this->message_from, $reply_message, 'individual', false);
                }

            }

            if ($this->channel == env('TELEGRAM_CHANNEL')) {

                $telegram = new Api(env('TELEGRAM_TOKEN'));

                $response = $telegram->sendMessage([
                    'chat_id' => $this->whatsapp_number,
                    'text' => $reply_message,
                    'parse_mode' => 'markdown'
                ]);
            }

            if ($this->channel == env('MESSENGER_CHANNEL')) {

                Log::info('MESSENGER8');

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
                            'id' => $this->whatsapp_number
                        ],
                        'message' => [
                            'text' => $reply_message
                        ]
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

        }

        if ($this->message_type == 'query_utilization') {

            $response = $client->request('POST', env('QUERY_UTILIZATION_URL'), [
                'timeout' => 45, // Response timeout
                'connect_timeout' => 30, // Connection timeout
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => $this->body
            ]);

            $array_response = (array)json_decode($response->getBody());

            $utilizations = $array_response['utilizations'];
            $details_results = (array)$array_response['cover_details'];

            $reply_message = "";

            $reply_message .= "*Name :* " . $details_results['MEMBER_NAME'] . "\n";
            $reply_message .= "*Membership No :* " . $details_results['DISPLAY_MEMBERSHIP_NO'] . "\n";
            $reply_message .= "*Cover Type :* " . $details_results['COVER_TYPE'] . "\n";
            $reply_message .= "*Status :* " . $details_results['POLICY_STATUS'] . "\n";
            $reply_message .= "*Start :* " . $details_results['POLICY_VALID_FROM'] . "\n";
            $reply_message .= "*End :* " . $details_results['POLICY_VALID_UPTO'] . "\n\n";

            $reply_message .= "*Usage*\n\n";

            foreach ($utilizations as $utilization) {

                $reply_message .= "*Name :* " . $utilization->MEMBER_DISPLAY_NAME . "\n";
                $reply_message .= "*Provider :* " . $utilization->PROVIDER_NAME . "\n";
                $reply_message .= "*Status :* " . $utilization->BILL_STATUS . "\n";
                $reply_message .= "*Amount :* Kes " . $utilization->PAYABLE_AMOUNT . "\n";
                $reply_message .= "*Date :* " . $utilization->RECEIVE_DATE . "\n\n";
            }

            $reply_message .= "\nThere you go!! 🙂 ... Please reply with *AAR* to go back to the main menu.";

            if ($this->channel == env('WHATSAPP_CHANNEL')) {

                if(env('WA_BOT_ENV') == 'TWILIO'){
                    // TWILIO API CREDENTIALS
                    $sid = env('TWILIO_SID');
                    $token = env('TWILIO_TOKEN');

                    // The TujengePay WhatsApp number
                    $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                    // Initialize the Twilio Client
                    $twilio = new \Twilio\Rest\Client($sid, $token);

                    $message = $twilio->messages
                        ->create("whatsapp:" . $this->whatsapp_number,
                            array(
                                "body" => $reply_message,
                                "from" => "whatsapp:" . $whatsapp_live_number
                            )
                        );
                }

                if(env('WA_BOT_ENV') == '360'){

                    $whatsAppServiceApi->send('text', $this->message_from, $reply_message, 'individual', false);
                }

            }

            if ($this->channel == env('TELEGRAM_CHANNEL')) {

                $telegram = new Api(env('TELEGRAM_TOKEN'));

                $response = $telegram->sendMessage([
                    'chat_id' => $this->whatsapp_number,
                    'text' => $reply_message,
                    'parse_mode' => 'markdown'

                ]);
            }

            if ($this->channel == env('MESSENGER_CHANNEL')) {

                Log::info('MESSENGER8');

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
                            'id' => $this->whatsapp_number
                        ],
                        'message' => [
                            'text' => $reply_message
                        ]
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

        }

        if ($this->message_type == 'query_cover') {

            $response = $client->request('POST', env('QUERY_COVER_URL'), [
                'timeout' => 45, // Response timeout
                'connect_timeout' => 30, // Connection timeout
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => $this->body
            ]);

            $array_response = (array)json_decode($response->getBody());

            $dependents = $array_response['members'];
            $details_results = (array)$array_response['cover_details'];

            $reply_message = "";

            $reply_message .= "*Name :* " . $details_results['MEMBER_NAME'] . "\n";
            $reply_message .= "*Membership No :* " . $details_results['DISPLAY_MEMBERSHIP_NO'] . "\n";
            $reply_message .= "*Cover Type :* " . $details_results['COVER_TYPE'] . "\n";
            $reply_message .= "*Inpatient Limit :* " . 'KES ' . number_format($array_response['in_patient'], 0) . "\n";
            $reply_message .= "*Outpatient Limit KES  :* " . 'KES ' . number_format($array_response['out_patient'], 0) . "\n";
            $reply_message .= "*Status :* " . $details_results['POLICY_STATUS'] . "\n";
            $reply_message .= "*Start :* " . $details_results['POLICY_VALID_FROM'] . "\n";
            $reply_message .= "*End :* " . $details_results['POLICY_VALID_UPTO'] . "\n\n";

            $reply_message .= "*Dependents*\n\n";

            if($dependents != false){

                foreach ($dependents as $dependent) {

                    $reply_message .= "*" . $dependent->MEMBER_NAME ."-". $dependent->DISPLAY_MEMBERSHIP_NO ."*\n\n";
                }

            }


            $reply_message .= "\nThere you go!! 🙂 ... Please reply with *AAR* to go back to the main menu.";

            if ($this->channel == env('WHATSAPP_CHANNEL')) {

                if(env('WA_BOT_ENV') == 'TWILIO'){
                    // TWILIO API CREDENTIALS
                    $sid = env('TWILIO_SID');
                    $token = env('TWILIO_TOKEN');

                    // The TujengePay WhatsApp number
                    $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                    // Initialize the Twilio Client
                    $twilio = new \Twilio\Rest\Client($sid, $token);

                    $message = $twilio->messages
                        ->create("whatsapp:" . $this->whatsapp_number,
                            array(
                                "body" => $reply_message,
                                "from" => "whatsapp:" . $whatsapp_live_number
                            )
                        );
                }

                if(env('WA_BOT_ENV') == '360'){

                    $whatsAppServiceApi->send('text', $this->message_from, $reply_message, 'individual', false);
                }

            }

            if ($this->channel == env('TELEGRAM_CHANNEL')) {

                $telegram = new Api(env('TELEGRAM_TOKEN'));

                $response = $telegram->sendMessage([
                    'chat_id' => $this->whatsapp_number,
                    'text' => $reply_message,
                    'parse_mode' => 'markdown'
                ]);
            }

            if ($this->channel == env('MESSENGER_CHANNEL')) {

                Log::info('MESSENGER8');

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
                            'id' => $this->whatsapp_number
                        ],
                        'message' => [
                            'text' => $reply_message
                        ]
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

        }

        if ($this->message_type == 'query_balance') {
            $response = $client->request('POST', env('QUERY_BALANCE_URL'), [
                'timeout' => 45, // Response timeout
                'connect_timeout' => 30, // Connection timeout
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => $this->body
            ]);

            $array_response = (array)json_decode($response->getBody());

            $balances_results = $array_response['balances'];
            $details_results = (array)$array_response['member_details'];

            $reply_message = "";

            $reply_message .= "*Name :* " . $details_results['MEMBER_NAME'] . "\n";
            $reply_message .= "*Membership No :* " . $details_results['DISPLAY_MEMBERSHIP_NO'] . "\n";
            $reply_message .= "*Cover Type :* " . $details_results['COVER_TYPE'] . "\n\n";

            $reply_message .= "*Here are your benefit balances*\n\n";

            foreach ($balances_results as $result) {

                $reply_message .= "*" . $result->BENEFIT . "*" . "\nLimit - KES " . number_format($result->LIMIT_AMT, 0) . "\nBalance - KES " . number_format($result->BALANCE, 0) . "\n\n";
            }

            $reply_message .= "\nThere you go!! 🙂 ... Please reply with *AAR* to go back to the main menu.";

            if ($this->channel == env('WHATSAPP_CHANNEL')) {

                if(env('WA_BOT_ENV') == 'TWILIO'){
                    // TWILIO API CREDENTIALS
                    $sid = env('TWILIO_SID');
                    $token = env('TWILIO_TOKEN');

                    // The TujengePay WhatsApp number
                    $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                    // Initialize the Twilio Client
                    $twilio = new \Twilio\Rest\Client($sid, $token);

                    $message = $twilio->messages
                        ->create("whatsapp:" . $this->whatsapp_number,
                            array(
                                "body" => $reply_message,
                                "from" => "whatsapp:" . $whatsapp_live_number
                            )
                        );
                }

                if(env('WA_BOT_ENV') == '360'){

                    $whatsAppServiceApi->send('text', $this->message_from, $reply_message, 'individual', false);

                }

            }

            if ($this->channel == env('TELEGRAM_CHANNEL')) {

                $telegram = new Api(env('TELEGRAM_TOKEN'));

                $response = $telegram->sendMessage([
                    'chat_id' => $this->whatsapp_number,
                    'text' => $reply_message,
                    'parse_mode' => 'markdown'
                ]);
            }

            if ($this->channel == env('MESSENGER_CHANNEL')) {

                Log::info('MESSENGER8');

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
                            'id' => $this->whatsapp_number
                        ],
                        'message' => [
                            'text' => $reply_message
                        ]
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

        }
    }
}
