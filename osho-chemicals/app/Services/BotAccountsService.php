<?php

namespace App\Services;

use App\Repositories\WhatsappAccountRepository;

class BotAccountsService
{
    public function getAccount($userId,
                               $channel,
                               WhatsappAccountRepository $whatsappAccountRepository)
                               {

        if($channel == env('WHATSAPP_CHANNEL')){
           return $whatsappAccountRepository->show($userId);
        }

    }

    public function storeAccount($userId,
                                 $channel,
                                 WhatsappAccountRepository $whatsappAccountRepository
                                 ){

        if($channel == env('WHATSAPP_CHANNEL')){
            return $whatsappAccountRepository->store($userId);
        }
    }

}
