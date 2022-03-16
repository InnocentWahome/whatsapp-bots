<?php


namespace App\Repositories;


use App\Models\TelegramAccount;

class TelegramAccountRepository
{
    public function show($userId){

        return TelegramAccount::where('chat_id', $userId)->first();
    }

    public function store($userId){

        $telegram_account = new TelegramAccount();

        $telegram_account->chat_id = $userId;

        $telegram_account->save();

        return $telegram_account;
    }
}
