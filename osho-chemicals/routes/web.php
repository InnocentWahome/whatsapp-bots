<?php

use App\Models\User;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BotSessionController;
use App\Models\UserSessionStep;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('layouts.dashboard');
});

Route::get('/user', function () {
    $users = User::paginate(2);
    return view('layouts.user')->with('users', $users);
});

Route::get('/user-step', function () {
    $user_steps = UserSessionStep::paginate(8);
    foreach($user_steps as $item){
        $user = User::where('id', $item->user_id)->first();
    }
    return view('layouts.user-step',compact('user_steps','user'));
});

Route::get('/index', [DashboardController::class, "index"]);


Route::get('s', function () {

    $whatsAppServices = new \App\Services\WhatsAppServiceApi();

    $buttons[] = [
        "type" => "reply",
        "reply" => [
            "id" => '4666',
            "title" => 'Get an Agrovet'
        ]
    ];

    $whatsAppServices->sendInteractiveButton('254716620009', $buttons, "*Damping-off*\n\nIt is a soil borne disease caused by several types of fungi affecting seedlings. It causes rotting of the seedling stems just above the soil line resulting in wilting, falling and death of the seedlings. If not controlled, it can result to 100% loss of seedlings, poor or no germination of seeds.\n\nSOLUTION.Drench the nursery with MATCO 72WP (50g/20L), MISTRESS 72WP (40g/20L), COMPANION 74WP (30g/20L).");

    dd('sent');
});

Route::get('ss', function (\Illuminate\Http\Request $request) {

    $data = $request->all();

    $contacts = $data['contacts'];

    dd($contacts[0]['profile']['name']);
});
