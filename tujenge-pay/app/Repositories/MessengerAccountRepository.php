<?php


namespace App\Repositories;


use App\Models\MessengerAccount;
use App\Models\TelegramAccount;

class MessengerAccountRepository
{
    public function show($userId){

        return MessengerAccount::where('sender', $userId)->first();
    }

    public function store($userId){

        $messenger_account = new MessengerAccount();

        $messenger_account->sender = $userId;

        $messenger_account->save();

        return $messenger_account;
    }
}
