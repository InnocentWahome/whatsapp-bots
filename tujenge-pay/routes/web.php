<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Api;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});


Route::get('/test', function () {

    dd(\App\Models\TestModel::take(10)->get());

});

Route::get('/test-aar', function () {

    dd(\App\Models\TestModel::take(10)->get());

});

Route::get('/test-a', function () {

    dd(\App\Models\MasterMemberList::where('DISPLAY_MEMBERSHIP_NO', '12233')->exists());
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/add-command', function () {

    $telegram = new Api(env('TELEGRAM_TOKEN'));


//    $telegram->addCommand(Telegram\Bot\Commands\HelpCommand::class);

//    dd(\Telegram\Bot\Laravel\Facades\Telegram::addCommand(\App\Console\Commands\MyCoverCommand::class));


    dd($telegram->addCommand(\App\Console\Commands\MyCoverCommand::class));


});

Route::post('pusher/auth', function () {
    return auth()->user();
});

Route::get('/conv', function () {


    $participants = [\App\User::where('email', 'karokijames40@gmail.com')->first(), \App\Models\WhatsappAccount::where('phone_number', '+254712675071')->first()];

    $conversation = Chat::createConversation($participants);

    dd($conversation);

});


$middleware = config('musonza_chat.routes.middleware');

Route::post('/v1/conversations/{id}/messages', 'CustomerCareMessagesController@store')
    ->middleware($middleware)
    ->name('conversations.messages.store');

Route::get('/ps', function () {

    $client = new Client();

    $response = $client->request('POST', 'https://graph.facebook.com/v11.0/me/messenger_profile?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg', [

        'headers' => [
            'Content-Type' => 'application/json',
        ],

        'body' => json_encode([

            "persistent_menu" => [
                [
                    "locale" => "default",
                    "composer_input_disabled" => false,
                    "call_to_actions" => [
                        [
                            "type" => "postback",
                            "title" => "Talk to an agent",
                            "payload" => "CARE_HELP"
                        ],
                        [
                            "type" => "postback",
                            "title" => "Outfit suggestions",
                            "payload" => "CURATION"
                        ],
                        [
                            "type" => "web_url",
                            "title" => "Shop now",
                            "url" => "https://www.originalcoastclothing.com/",
                            "webview_height_ratio" => "full"
                        ]
                    ]
                ]
            ]
        ])
    ]);

    $data = (array)json_decode($response->getBody());

    dd($data);
});

Route::get('/bt', function () {

    $client = new Client();

    $response = $client->request('POST', 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg', [

        'headers' => [
            'Content-Type' => 'application/json',
        ],

        'body' => json_encode([
            'recipient' => [
                'id' => '3439900849443800',
            ],
            'message' => [
                'attachment' => [
                    'type' => 'template',
                    'payload' => [
                        'template_type' => 'button',
                        'text' => 'Try the postback button!',
                        'buttons' => [
                            [
                                'type' => 'postback',
                                'title' => 'Postback Button',
                                'payload' => 'DEVELOPER_DEFINED_PAYLOAD',
                            ],
                            [
                                'type' => 'postback',
                                'title' => 'Postback Button',
                                'payload' => 'DEVELOPER_DEFINED_PAYLOAD',
                            ],
                            [
                                'type' => 'postback',
                                'title' => 'Postback Button',
                                'payload' => 'DEVELOPER_DEFINED_PAYLOAD',
                            ]
                        ],
                    ],
                ],
            ],
        ])
    ]);

    $data = (array)json_decode($response->getBody());

    dd($data);
});

Route::get('/qr', function () {

    $client = new Client();

    $response = $client->request('POST', 'https://graph.facebook.com/v2.6/me/messages?access_token=EAAgMHGTPdMUBAPGyJZCGoj8cYIZB4eZAkXVxy9RpKFOh2ksrOZA39b1R1ZAZBjAXKQZCDLPoxuaXFC2KwZBG2PKNJhebLaHi02JvCQI4GQitHDslI02ZA8Ate3BGalSrR0ZCROr3tV1d50UucapTZA7nEzOBUzlZA0QOi6VbcVVozFOlnC00yYle06Xg', [

        'headers' => [
            'Content-Type' => 'application/json',
        ],

        'body' => json_encode([
            'recipient' => [
                'id' => '3439900849443800',
            ],
            'messaging_type' => 'RESPONSE',
            'message' => [
                'text' => 'Pick a color',
                'quick_replies' => [
                    [
                        'content_type' => 'text',
                        'title' => 'Red',
                        'payload' => 'red',
                    ],
                    [
                        'content_type' => 'text',
                        'title' => 'Green',
                        'payload' => 'green',
                    ],
                ],
            ],
        ])
    ]);

    $data = (array)json_decode($response->getBody());

    dd($data);
});

Route::get('/sm', function () {

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://chatway.co.ke/account/api/v1/sendsms',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('to' => '254712675071','message' => 'Dear Test. Notification'),
        CURLOPT_HTTPHEADER => array( 'Authorization: Bearer d373b4f46a307e6a6cff6526343c06ca:cf89f7-e865c4-c266ba-005aeb-c44b09'
        ), ));
    $response = curl_exec($curl); curl_close($curl);
    echo $response;
});


Route::get('/dt', function () {


});

