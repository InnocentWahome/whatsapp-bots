<?php

namespace App\Repositories;

use App\Models\BotSession;
use App\Models\BotSessionStep;

class BotSessionRepository
{
    public function checkIfSessionExistsByName($channel, $message){

        if(BotSession::where('session_name', $message)
            ->where('channel', $channel)
            ->exists()){
            return true;
        }

        return false;
    }

    public function getParentBotSessionStep($bot_session, $bot_response){

        return BotSessionStep::where('bot_session_id', $bot_session->id)
            ->where('session_step_key', $bot_response->next_session_step)
            ->first();
    }

    public function getZeroBotStep($channel, $bot_session){

        return BotSessionStep::where('bot_session_id', $bot_session->id)
            ->where('session_step_key', 0)
            ->first();
    }


    public function getNextBotSession($channel, $message){

        if(BotSession::where('channel', $channel)
            ->where('session_key_word', $message)
            ->exists()){
            return BotSession::where('channel', $channel)
                ->where('session_key_word', $message)
                ->first();
        }

        return false;
    }
}
