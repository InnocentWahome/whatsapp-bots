<?php

namespace App\Services;


use App\Repositories\MessengerAccountRepository;
use App\Repositories\TelegramAccountRepository;
use App\Repositories\WhatsappAccountRepository;

class BotAccountsService
{
    public function getAccount($userId,
                               $channel,
                               WhatsappAccountRepository $whatsappAccountRepository,
                               TelegramAccountRepository $telegramAccountRepository,
                               MessengerAccountRepository $messengerAccountRepository){

        if($channel == env('WHATSAPP_CHANNEL')){
           return $whatsappAccountRepository->show($userId);
        }

        if($channel == env('TELEGRAM_CHANNEL')){

            return $telegramAccountRepository->show($userId);
        }

        if($channel == env('MESSENGER_CHANNEL')){

            return $messengerAccountRepository->show($userId);
        }
    }

    public function storeAccount($userId,
                                 $channel,
                                 WhatsappAccountRepository $whatsappAccountRepository,
                                 TelegramAccountRepository $telegramAccountRepository,
                                 MessengerAccountRepository $messengerAccountRepository){

        if($channel == env('WHATSAPP_CHANNEL')){
            return $whatsappAccountRepository->store($userId);
        }

        if($channel == env('TELEGRAM_CHANNEL')){
            return $telegramAccountRepository->store($userId);
        }

        if($channel == env('MESSENGER_CHANNEL')){
            return $messengerAccountRepository->store($userId);
        }
    }

}
