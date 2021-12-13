<?php

namespace App\Repositories;

use App\Models\WhatsappAccount;

class WhatsappAccountRepository
{
    public function show($userId){

        return WhatsappAccount::where('phone_number', $userId)->first();
    }

    public function store($userId){

        $whatsapp_account = new WhatsappAccount();

        $whatsapp_account->phone_number = $userId;

        $whatsapp_account->save();

        return $whatsapp_account;
    }

}
