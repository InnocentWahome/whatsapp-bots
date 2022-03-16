<?php


namespace App\Repositories;


use App\Models\BotSession;
use App\Models\BotResponse;
use App\Models\BotSessionStep;
use App\Models\WhatsappAccount;
use App\Models\WhatsappSession;
use App\Models\WhatsappSessionStep;
use Illuminate\Support\Facades\Log;

class WhatsappSessionRepository
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

        if (WhatsappSession::where('phone_number', $user_id)
                             ->where('session_status', 'active')
                            ->exists()) {

            return true;
        }

        return false;
    }

    public function getSession($user_id)
    {
        return WhatsappSession::where('phone_number', $user_id)
            ->where('session_status', 'active')
            ->first();
    }

    public function storeSession($user_id, $bot_account, $bot_session){

        $whatsapp_session = new WhatsappSession();

        $whatsapp_session->phone_number = $user_id;
        $whatsapp_session->whatsapp_account_id = $bot_account->id;
        $whatsapp_session->bot_session_id = $bot_session->id;
        Log::info("bot id: " .$bot_session->id);

        $whatsapp_session->save();

        return $whatsapp_session;
    }

    public function checkIfActiveStepExists($user_id, $channel, $bot_account){

        if(WhatsappSessionStep::where('whatsapp_account_id', $bot_account->id)
                                ->where('status', 'active')
                                ->exists()){
            return true;
        }

        return false;
    }

    public function deactivateWhatsAppSession($user_id){

        $user_sessions = WhatsappSession::where('phone_number', $user_id)->get();

        foreach ($user_sessions as $user_session){

            $user_session->session_status = 'inactive';

            $user_session->save();
        }

        $whatsapp_account = WhatsappAccount::where('phone_number', $user_id)->first();

        $this->deactivateWhatsappSessionStep($user_id, env('WHATSAPP_CHANNEL'), $whatsapp_account);
    }

    public function deactivateWhatsappSessionStep($user_id, $channel, $bot_account){

        $whatsapp_session_steps = WhatsappSessionStep::where('whatsapp_account_id', $bot_account->id)->get();

        foreach ($whatsapp_session_steps as $whatsapp_session_step){

            $whatsapp_session_step->status = 'inactive';

            $whatsapp_session_step->save();
        }
    }

    public function storeSessionStep($session, $bot_account, $bot_session){

        $whatsapp_session_step = new WhatsappSessionStep();

        $whatsapp_session_step->whatsapp_session_id = $session->id;
        $whatsapp_session_step->whatsapp_account_id = $bot_account->id;
        $whatsapp_session_step->bot_session_step_id = $bot_session->id;

        $whatsapp_session_step->save();

        return $whatsapp_session_step;
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

    public function getActiveBotStep($whatsapp_account_id){

        return WhatsappSessionStep::where('whatsapp_account_id', $whatsapp_account_id)
                                    ->where('status', 'active')
                                    ->first();
    }







}
