<?php


namespace App\Services;


use App\Models\BotResponse;
use App\Models\BotSession;
use App\Models\BotSessionStep;
use App\Repositories\BotSessionRepository;
use App\Repositories\WhatsappSessionRepository;
use Illuminate\Support\Facades\Log;

class BotSessionService
{
    public function processSession(
        $userId,
        $channel,
        $bot_account,
        $bot_session,
        WhatsappSessionRepository $whatsappSessionRepository
    ) {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            $whatsappSessionRepository->deactivateWhatsAppSession($userId);

            $session = $whatsappSessionRepository->storeSession($userId, $bot_account, $bot_session);
        }

        return $session;
    }

    public function getBotSession($channel, $session_name)
    {

        return BotSession::where('session_name', $session_name)
            ->where('channel', $channel)
            ->first();
    }

    public function getBotStep($message, $channel, $bot_session)
    {

        //change to bot session step
        return BotSessionStep::where('bot_session_id', $bot_session->id)
            ->where('channel', $channel)
            ->first();
    }

    public function getInitialBotStep($message, $channel, $bot_session)
    {

        //change to bot session step
        return BotSessionStep::where('bot_session_id', $bot_session->id)
            ->where('is_initial_step', true)
            ->where('channel', $channel)
            ->first();
    }

    public function getBotResponses($message, $channel, $bot_session, $bot_step, $active_bot_step)
    {

        if($active_bot_step->is_next_step_session){

            $bot_session = $this->getBotSession($channel, $active_bot_step->next_session);

            $bot_step = BotSessionStep::where('bot_session_id', $bot_session->id)
                //  ->where('session_step_key', $bot_step->next_session_step_key)
                ->where('session_step_key', 0)
                ->where('is_initial_step', true)
                ->first();

            return BotResponse::where('bot_session_id', $bot_session->id)
                ->where('channel', $channel)
                ->where('bot_session_step_id', $bot_step->id)
                // ->orderBy('LENGTH(key_word)', 'asc')
                ->orderByRaw("CAST(key_word as UNSIGNED) ASC")
                // ->orderBy('key_word', 'asc')
                ->get();


        }else{
            return BotResponse::where('bot_session_id', $bot_session->id)
                ->where('channel', $channel)
                ->where('bot_session_step_id', $bot_step->id)
                // ->orderBy('LENGTH(key_word)', 'asc')
                ->orderByRaw("CAST(key_word as UNSIGNED) ASC")
                // ->orderBy('key_word', 'asc')
                ->get();
        }
    }

    public function setSessionStep(
        $session,
        $channel,
        $user_id,
        $message,
        $bot_account,
        $bot_step,
        WhatsappSessionRepository $whatsappSessionRepository
    ) {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            return $whatsappSessionRepository->storeSessionStep($session, $bot_account, $bot_step);
        }
    }

    public function checkForActiveSession(
        $user_id,
        $channel,
        WhatsappSessionRepository $whatsappSessionRepository
    ) {
        if ($channel == env('WHATSAPP_CHANNEL')) {

            return $whatsappSessionRepository->checkForActiveSession($user_id->phone_number);
        }
    }

    public function responseForSessionExists(
        $bot_session,
        $message,
        $channel,
        WhatsappSessionRepository $whatsappSessionRepository
    ) {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            return $whatsappSessionRepository->sessionResponseExists($bot_session, $message);
        }
    }

    public function getBotResponse(
        $bot_session,
        $message,
        $channel,
        WhatsappSessionRepository $whatsappSessionRepository
    ) {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            return $whatsappSessionRepository->getBotResponse($bot_session, $message);
        }
    }

    public function getParentBotSessionStep($bot_session, $bot_response, $channel, WhatsappSessionRepository $whatsappSessionRepository)
    {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            //       return $whatsappSessionRepository->getParentBotSessionStep($bot_session, $bot_response);
        }
    }

    public function getNextBotStep($channel, $bot_step, $message)
    {

        Log::info('BSID ' . $bot_step->bot_session_id);
        Log::info('SSKEY ' . $bot_step->next_session_step_key);

        if($bot_step->is_next_step_session){

            $bot_session = $this->getBotSession($channel, $bot_step->next_session);

            return BotSessionStep::where('bot_session_id', $bot_session->id)
                //  ->where('session_step_key', $bot_step->next_session_step_key)
                ->where('session_step_key', 0)
                ->where('is_initial_step', true)
                ->first();

        }else{

            if ($bot_step->with_input) {

                if($bot_response = BotResponse::where('bot_session_step_id', $bot_step->id)
                    //            ->where('session_step_key', $bot_step->next_session_step_key)
                    ->where('key_word', $message)
                    ->exists()){
                    $bot_response = BotResponse::where('bot_session_step_id', $bot_step->id)
                        //            ->where('session_step_key', $bot_step->next_session_step_key)
                        ->where('key_word', $message)
                        ->first();

                    if(BotSessionStep::where('bot_session_id', $bot_step->bot_session_id)
                        //  ->where('session_step_key', $bot_step->next_session_step_key)
                        ->where('session_step_key', $bot_response->next_session_step)
                        ->exists()){

                        return BotSessionStep::where('bot_session_id', $bot_step->bot_session_id)
                            //  ->where('session_step_key', $bot_step->next_session_step_key)
                            ->where('session_step_key', $bot_response->next_session_step)
                            ->first();
                    }

                    return false;
                }

                return false;


            } else {
                $bot_response = BotResponse::where('bot_session_step_id', $bot_step->id)
                    //            ->where('session_step_key', $bot_step->next_session_step_key)
                    ->where('key_word', $message)
                    ->first();
                return BotSessionStep::where('bot_session_id', $bot_step->bot_session_id)
                    //    ->where('session_step_key', $bot_response->next_session_step)
                    ->where('session_step_key', $bot_step->next_session_step_key)
                    ->first();
            }
        }
    }

    public function getBotStepById($id){

        return BotSessionStep::where('id', $id)->first();
    }

    public function getPreviousBotStep($channel, $bot_step, $message){

        Log::info('SSK: '.  $bot_step->previous_session_step);
        Log::info('BSID: '.  $bot_step->bot_session_id);

        return BotSessionStep::where('session_step_key', $bot_step->previous_session_step)
           ->where('bot_session_id', $bot_step->bot_session_id)
           ->first();

    }

    public function getActiveBotStep(
        $bot_account,
        $channel,
        WhatsappSessionRepository $whatsappSessionRepository
    ) {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            return $whatsappSessionRepository->getActiveBotStep($bot_account->id);
        }
    }

    public function getActiveSession(
        $channel,
        $user_id,
        WhatsappSessionRepository $whatsappSessionRepository
    ) {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            return $whatsappSessionRepository->getSession($user_id);
        }
    }

    public function checkIfSessionExistsByName($channel, $message, BotSessionRepository $botSessionRepository)
    {
        return $botSessionRepository->checkIfSessionExistsByName($channel, $message);
    }

    public function getNextBotSession($channel, $message, BotSessionRepository $botSessionRepository)
    {

        return $botSessionRepository->getNextBotSession($channel, $message);
    }

    public function getZeroBotSessionStep($channel, $bot_session, BotSessionRepository $botSessionRepository)
    {

        return $botSessionRepository->getZeroBotStep($channel, $bot_session);
    }

    public function deactivateBotSession(
        $channel,
        $user_identifier,
        WhatsappSessionRepository $whatsappSessionRepository
    ) {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            $whatsappSessionRepository->deactivateWhatsAppSession($user_identifier);
        }
    }

    public function deactivateBotSessionSteps(
        $channel,
        $user_identifier,
        $bot_account,
        WhatsappSessionRepository $whatsappSessionRepository
    ) {
        if ($channel == env('WHATSAPP_CHANNEL')) {

            $whatsappSessionRepository->deactivateWhatsappSessionStep($user_identifier, $channel, $bot_account);
        }
    }
}
