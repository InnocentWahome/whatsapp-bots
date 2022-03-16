<?php


namespace App\Repositories;


use App\Models\BotResponse;
use App\Models\BotSession;
use App\Models\BotSessionStep;
use App\Models\TelegramAccount;
use App\Models\TelegramSession;
use App\Models\TelegramSessionStep;
use App\Models\WhatsappAccount;
use App\Models\WhatsappSession;
use App\Models\WhatsappSessionStep;

class TelegramSessionRepository
{
    public function checkIfSessionExists($user_id)
    {

        if (WhatsappSession::where('phone_number', $user_id)->exists()) {

            return true;
        }

        return false;
    }

    public function checkForActiveSession($user_id)
    {

        if (TelegramSession::where('chat_id', $user_id)
                             ->where('session_status', 'active')
                            ->exists()) {

            return true;
        }

        return false;
    }

    public function getSession($user_id)
    {
        return TelegramSession::where('chat_id', $user_id)
            ->where('session_status', 'active')
            ->first();
    }

    public function storeSession($user_id, $bot_account, $bot_session){

        $telegram_session = new TelegramSession();

        $telegram_session->chat_id = $user_id;
        $telegram_session->telegram_account_id = $bot_account->id;
        $telegram_session->bot_session_id = $bot_session->id;

        $telegram_session->save();

        return $telegram_session;
    }

    public function checkIfActiveStepExists($user_id, $channel, $bot_account){

        if(WhatsappSessionStep::where('whatsapp_account_id', $bot_account->id)
                                ->where('status', 'active')
                                ->exists()){
            return true;
        }

        return false;
    }

    public function deactivateTelegramSession($user_id){

        $user_sessions = TelegramSession::where('chat_id', $user_id)->get();

        foreach ($user_sessions as $user_session){

            $user_session->session_status = 'inactive';

            $user_session->save();
        }

        $telegram_account = TelegramAccount::where('chat_id', $user_id)->first();

        $this->deactivateTelegramSessionStep($user_id, env('TELEGRAM_CHANNEL'), $telegram_account);
    }

    public function deactivateMessengerSession($user_id){

        $user_sessions = TelegramSession::where('chat_id', $user_id)->get();

        foreach ($user_sessions as $user_session){

            $user_session->session_status = 'inactive';

            $user_session->save();
        }

        $telegram_account = TelegramAccount::where('chat_id', $user_id)->first();

        $this->deactivateTelegramSessionStep($user_id, env('TELEGRAM_CHANNEL'), $telegram_account);
    }

    public function deactivateTelegramSessionStep($user_id, $channel, $bot_account){

        $telegram_session_steps = TelegramSessionStep::where('telegram_account_id', $bot_account->id)->get();

        foreach ($telegram_session_steps as $telegram_session_step){

            $telegram_session_step->status = 'inactive';

            $telegram_session_step->save();
        }
    }



    public function storeSessionStep($session, $bot_account, $bot_session){

        $telegram_session_step = new TelegramSessionStep();

        $telegram_session_step->telegram_session_id = $session->id;
        $telegram_session_step->telegram_account_id = $bot_account->id;
        $telegram_session_step->bot_session_step_id = $bot_session->id;

        $telegram_session_step->save();

        return $telegram_session_step;
    }

    public function sessionResponseExists($bot_session, $message){


        if(BotResponse::where('bot_session_id', $bot_session->id)
                        ->where('key_word', $message)
                        ->exists()){
            return true;
        }

        return false;
    }

    public function getBotResponse($bot_session, $message){

        return BotResponse::where('bot_session_id', $bot_session->id)
            ->where('key_word', $message)
            ->first();
    }

    public function getActiveBotStep($telegram_account_id){

        return TelegramSessionStep::where('telegram_account_id', $telegram_account_id)
                                    ->where('status', 'active')
                                    ->first();
    }

    public function getParentBotSessionStep($bot_session, $bot_response){

        return BotSessionStep::where('bot_session_id', $bot_session->id)
            ->where('session_step_key', $bot_response->next_session_step)
            ->first();
    }



    public function getNextBotSession($channel, $message){

        return BotSession::where('channel', $channel)
                           ->where('session_key_word', $message)
                           ->first();
    }

    public function getZeroBotStep($channel, $bot_session){

        return BotSessionStep::where('bot_session_id', $bot_session->id)
                              ->where('session_step_key', 0)
                              ->first();
    }
}
