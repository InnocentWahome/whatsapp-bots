<?php


namespace App\Services;


use App\Models\BotResponse;
use App\Models\BotSession;
use App\Models\BotSessionStep;
use App\Repositories\BotSessionRepository;
use App\Repositories\MessengerSessionRepository;
use App\Repositories\TelegramSessionRepository;
use App\Repositories\WhatsappSessionRepository;
use Illuminate\Support\Facades\Log;

class BotSessionService
{
    public function processSession($userId,
                                   $channel,
                                   $bot_account,
                                   $bot_session,
                                   WhatsappSessionRepository $whatsappSessionRepository,
                                   TelegramSessionRepository $telegramSessionRepository,
                                   MessengerSessionRepository $messengerSessionRepository)
    {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            $whatsappSessionRepository->deactivateWhatsAppSession($userId);

            $session = $whatsappSessionRepository->storeSession($userId, $bot_account, $bot_session);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            $telegramSessionRepository->deactivateTelegramSession($userId);

            $session = $telegramSessionRepository->storeSession($userId, $bot_account, $bot_session);

        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $messengerSessionRepository->deactivateTelegramSession($userId);

            $session = $messengerSessionRepository->storeSession($userId, $bot_account, $bot_session);

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

    public function getBotResponses($message, $channel, $bot_session, $bot_step)
    {
        Log::info('BOT RESPONSE BOT STEP '.$bot_step);

        return BotResponse::where('bot_session_id', $bot_session->id)
            ->where('channel', $channel)
//                            ->where('key_word', $message)
            ->where('bot_session_step_id', $bot_step->id)
            ->get();
    }

    public function setSessionStep($session,
                                   $channel,
                                   $user_id,
                                   $message,
                                   $bot_account,
                                   $bot_step,
                                   WhatsappSessionRepository $whatsappSessionRepository,
                                   TelegramSessionRepository $telegramSessionRepository,
                                   MessengerSessionRepository $messengerSessionRepository)
    {

        if ($channel == env('WHATSAPP_CHANNEL')) {

//            $active_step_exists = $whatsappSessionRepository->checkIfActiveStepExists($user_id, $channel, $bot_account);

//            if($active_step_exists){
//
//                $whatsappSessionRepository->deactivateWhatsappSessionStep($user_id, $channel, $bot_account);
//            }
//

            return $whatsappSessionRepository->storeSessionStep($session, $bot_account, $bot_step);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

//            $active_step_exists = $whatsappSessionRepository->checkIfActiveStepExists($user_id, $channel, $bot_account);

//            if($active_step_exists){
//
//                $whatsappSessionRepository->deactivateWhatsappSessionStep($user_id, $channel, $bot_account);
//            }
//

            return $telegramSessionRepository->storeSessionStep($session, $bot_account, $bot_step);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

//            $active_step_exists = $whatsappSessionRepository->checkIfActiveStepExists($user_id, $channel, $bot_account);

//            if($active_step_exists){
//
//                $whatsappSessionRepository->deactivateWhatsappSessionStep($user_id, $channel, $bot_account);
//            }
//

            return $messengerSessionRepository->storeSessionStep($session, $bot_account, $bot_step);
        }
    }

    public function checkForActiveSession($user_id,
                                          $channel,
                                          WhatsappSessionRepository $whatsappSessionRepository,
                                          TelegramSessionRepository $telegramSessionRepository,
                                          MessengerSessionRepository $messengerSessionRepository)
    {
        if ($channel == env('WHATSAPP_CHANNEL')) {

            return $whatsappSessionRepository->checkForActiveSession($user_id->phone_number);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            return $telegramSessionRepository->checkForActiveSession($user_id->chat_id);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            return $messengerSessionRepository->checkForActiveSession($user_id->sender);
        }

    }

    public function responseForSessionExists($bot_session, $message, $channel,
                                             WhatsappSessionRepository $whatsappSessionRepository,
                                             TelegramSessionRepository $telegramSessionRepository,
                                             MessengerSessionRepository $messengerSessionRepository)
    {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            return $whatsappSessionRepository->sessionResponseExists($bot_session, $message);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            return $telegramSessionRepository->sessionResponseExists($bot_session, $message);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            return $messengerSessionRepository->sessionResponseExists($bot_session, $message);
        }
    }

    public function getBotResponse($bot_session, $message, $channel,
                                   WhatsappSessionRepository $whatsappSessionRepository,
                                   TelegramSessionRepository $telegramSessionRepository,
                                   MessengerSessionRepository $messengerSessionRepository)
    {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            return $whatsappSessionRepository->getBotResponse($bot_session, $message);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            return $telegramSessionRepository->getBotResponse($bot_session, $message);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            return $messengerSessionRepository->getBotResponse($bot_session, $message);
        }
    }

    public function getParentBotSessionStep($bot_session, $bot_response, $channel, WhatsappSessionRepository $whatsappSessionRepository)
    {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            return $whatsappSessionRepository->getParentBotSessionStep($bot_session, $bot_response);
        }

    }

    public function getNextBotStep($channel, $bot_step, $message)
    {

        Log::info('BSID ' . $bot_step->bot_session_id);
        Log::info('SSKEY ' . $bot_step->next_session_step_key);
        Log::info('BOTSTEPID' .$bot_step->id);

        if ($bot_step->with_input) {

            return BotSessionStep::where('bot_session_id', $bot_step->bot_session_id)
                ->where('session_step_key', $bot_step->next_session_step_key)
                ->first();
        }


        if(BotResponse::where('bot_session_step_id', $bot_step->id)
//            ->where('session_step_key', $bot_step->next_session_step_key)
            ->where('key_word', $message)->exists()){

            $bot_response = BotResponse::where('bot_session_step_id', $bot_step->id)
//            ->where('session_step_key', $bot_step->next_session_step_key)
                ->where('key_word', $message)
                ->first();

            return BotSessionStep::where('bot_session_id', $bot_step->bot_session_id)
                ->where('session_step_key', $bot_response->next_session_step)
                ->first();
        }

        return false;

    }

    public function getActiveBotStep($bot_account,
                                     $channel,
                                     WhatsappSessionRepository $whatsappSessionRepository,
                                     TelegramSessionRepository $telegramSessionRepository,
                                     MessengerSessionRepository $messengerSessionRepository)
    {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            return $whatsappSessionRepository->getActiveBotStep($bot_account->id);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            return $telegramSessionRepository->getActiveBotStep($bot_account->id);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            return $messengerSessionRepository->getActiveBotStep($bot_account->id);
        }

    }

    public function getActiveSession($channel,
                                     $user_id,
                                     WhatsappSessionRepository $whatsappSessionRepository,
                                     TelegramSessionRepository $telegramSessionRepository,
                                     MessengerSessionRepository $messengerSessionRepository)
    {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            return $whatsappSessionRepository->getSession($user_id);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            return $telegramSessionRepository->getSession($user_id);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            return $messengerSessionRepository->getSession($user_id);
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

    public function deactivateBotSession($channel,
                                         $user_identifier,
                                         WhatsappSessionRepository $whatsappSessionRepository,
                                         TelegramSessionRepository $telegramSessionRepository,
                                         MessengerSessionRepository $messengerSessionRepository)
    {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            $whatsappSessionRepository->deactivateWhatsAppSession($user_identifier);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            $telegramSessionRepository->deactivateTelegramSession($user_identifier);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $messengerSessionRepository->deactivateTelegramSession($user_identifier);
        }
    }

    public function deactivateBotSessionSteps($channel,
                                              $user_identifier,
                                              $bot_account,
                                              WhatsappSessionRepository $whatsappSessionRepository,
                                              TelegramSessionRepository $telegramSessionRepository,
                                              MessengerSessionRepository $messengerSessionRepository)
    {
        if ($channel == env('WHATSAPP_CHANNEL')) {

            $whatsappSessionRepository->deactivateWhatsappSessionStep($user_identifier, $channel, $bot_account);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            $telegramSessionRepository->deactivateTelegramSessionStep($user_identifier, $channel, $bot_account);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $messengerSessionRepository->deactivateTelegramSessionStep($user_identifier, $channel, $bot_account);
        }
    }
}
