<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;

class TelegramBotApiController extends Controller
{
    public function bot()
    {

        $telegram = new Api(env('TELEGRAM_TOKEN'));

        $response = $telegram->getMe();

        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();

        dd($username);
    }

    public function setWebHook()
    {

        $client = new Client();

        $res = $client->request('GET', 'https://api.telegram.org/bot1923125320:AAHHzsBkrsB3wbivWgnVw3DJNmYFXh4xvhU/setWebhook?url=https://api.sasa.ai/api/v1/telegram/updates');

        dd($res);
    }

    public function getWebHookInfo()
    {

        $client = new Client();

        $res = $client->request('GET', 'https://api.telegram.org/bot1704393829:AAEpMNWl4RBjdx7H2tVpiEMmBdKZpesQJVE/getWebhookInfo');

        dd(json_decode($res->getBody()));
    }

    public function setCommands()
    {

        $ch = curl_init();

        $body = [
    "commands" => [
        [
            "command" => "start",
            "description" => "Start chatting with the AAR bot"
        ]
//        ,
//        [
//            "command" => "mycover",
//            "description" => "Get my cover information"
//        ],
//        [
//            "command" => "benefitbalances",
//            "description" => "Get my benefit balances"
//        ],
//        [
//            "command" => "coverutilization",
//            "description" => "Get my cover utilizations"
//        ],
//        [
//            "command" => "claims",
//            "description" => "File and track claims"
//        ],
//        [
//            "command" => "pay",
//            "description" => "Make payments"
//        ],
//        [
//            "command" => "getquote",
//            "description" => "Get a quote"
//        ],
//        [
//            "command" => "letters",
//            "description" => "Request for embassy, travel and confirmation letters"
//        ],
//        [
//            "command" => "buyinsurance",
//            "description" => "Buy AAR insurance products"
//        ],
//        [
//            "command" => "customercare",
//            "description" => "Chat with customer care"
//        ]
    ]];

        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot1704393829:AAEpMNWl4RBjdx7H2tVpiEMmBdKZpesQJVE/setMyCommands');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));



        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        dd($ch);

//        $client = new Client();
//
//        $res = $client->request('POST', 'https://api.telegram.org/bot1704393829:AAEpMNWl4RBjdx7H2tVpiEMmBdKZpesQJVE/setMyCommands', [
//            'headers' => [
//                'Content-Type' => 'application/json',
//            ],
//            '{
//    "commands": [
//        {
//            "command": "alert",
//            "description": "Define an alert to be sent if a carpark becomes available with greater than the defined number of spaces"
//        }
//    ]
//}'
//        ]);

//        dd(json_decode($res->getBody()));

    }

    public function sendKeyBoard()
    {
        $telegram = new Api(env('TELEGRAM_TOKEN'));

        $keyboard = [
            ['7', '8', '9'],
            ['4', '5', '6'],
            ['1', '2', '3'],
            ['0']
        ];

        $reply_markup = $telegram->replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        $response = $telegram->sendMessage([
            'chat_id' => '380183470',
            'text' => 'Hello World',
            'reply_markup' => $reply_markup
        ]);

        $messageId = $response->getMessageId();

        dd($messageId);

    }

    public function sendKeyBoardButton()
    {
        $telegram = new Api(env('TELEGRAM_TOKEN'));

        $keyboard = [
            ['My cover'],
            ['Benefit balances'],
            ['Cover utilization'],
            ['Claims'],
            ['Pay'],
            ['Premium statement'],
            ['Request for quote'],
            ['Request for letters'],
            ['Buy insurance product'],
            ['Customer care']
        ];

        $reply_markup = $telegram->replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        $response = $telegram->sendMessage([
            'chat_id' => '380183470',
            'text' => 'Hello World',
            'reply_markup' => $reply_markup
        ]);

        $messageId = $response->getMessageId();

        dd($messageId);

    }

    public function sendInlineKeyBoard()
    {
        $telegram = new Api(env('TELEGRAM_TOKEN'));

        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'My cover', 'callback_data' => '/start'],
//                    ['text' => 'Benefit balances', 'callback_data' => 'someString'],
//                    ['text' => 'Cover utilization', 'callback_data' => 'someString'],
//                    ['text' => 'Claims', 'callback_data' => 'someString'],
//                    ['text' => 'Pay', 'callback_data' => 'someString'],
//                    ['text' => 'Premium Statement', 'callback_data' => 'someString'],
//                    ['text' => 'Request for quote', 'callback_data' => 'someString'],
//                    ['text' => 'Request for letters', 'callback_data' => 'someString'],
//                    ['text' => 'Buy insurance', 'callback_data' => 'someString'],
//                    ['text' => 'Customer care', 'callback_data' => 'someString']
                ]
            ]
        ];
        $encodedKeyboard = json_encode($keyboard);

        $response = $telegram->sendMessage([
            'chat_id' => '380183470',
            'text' => 'Hello World',
            'reply_markup' => $encodedKeyboard
        ]);

        $messageId = $response->getMessageId();

        dd($messageId);

    }

    public function getMyCommands()
    {

        $client = new Client();

        $res = $client->request('GET', 'https://api.telegram.org/bot1704393829:AAEpMNWl4RBjdx7H2tVpiEMmBdKZpesQJVE/getMyCommands');

        dd(json_decode($res->getBody()));

    }


    public function messengerUpdates()
    {

//        $challenge = $_REQUEST['hub_challenge'];
//        $verify_token = $_REQUEST['hub_verify_token'];
//
//// Set this Verify Token Value on your Facebook App
//        if ($verify_token === '*jayjay123#') {
//            echo $challenge;
//        }

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
        "text":"The message you want to return"
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

}
