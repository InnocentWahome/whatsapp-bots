<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('v1/botengine',  [\App\Http\Controllers\BotEngineController::class, 'botEngine']);


Route::post('v1/botengineV2',  [\App\Http\Controllers\BotEngineController::class, 'botEngine']);

Route::post('v1/telegram', [\App\Http\Controllers\TelegramBotApiController::class, 'bot']);

Route::get('v1/messenger/updates', [\App\Http\Controllers\BotEngineController::class, 'confirmMessenger']);

Route::post('v1/messenger/updates', [\App\Http\Controllers\BotEngineController::class, 'messengerUpdates']);

Route::post('/v1/telegram/set-webhook', [\App\Http\Controllers\TelegramBotApiController::class, 'setWebHook']);

Route::post('/v1/telegram/get-webhook-info', [\App\Http\Controllers\TelegramBotApiController::class, 'getWebHookInfo']);

Route::post('/v1/telegram/set-command', [\App\Http\Controllers\TelegramBotApiController::class, 'setCommands']);

Route::post('/v1/telegram/get-commands', [\App\Http\Controllers\TelegramBotApiController::class, 'getMyCommands']);

Route::post('/v1/telegram/send-keyboard', [\App\Http\Controllers\TelegramBotApiController::class, 'sendKeyBoard']);

Route::post('/v1/telegram/send-inline-keyboard', [\App\Http\Controllers\TelegramBotApiController::class, 'sendInlineKeyBoard']);

Route::post('/v1/telegram/send-keyboard-button', [\App\Http\Controllers\TelegramBotApiController::class, 'sendKeyBoardButton']);

Route::post('v1/telegram/updates', [\App\Http\Controllers\BotEngineController::class, 'botUpdates']);








