<?php

namespace App\Http\Controllers;

use App\Services\BotServices;
use App\Services\WhatsAppServiceApi;
use Illuminate\Http\Request;
use Musonza\Chat\Http\Requests\StoreMessage;
use Chat;



class CustomerCareMessagesController extends Controller
{
    protected $messageTransformer;

    public function __construct()
    {
        $this->setUp();
    }

    private function setUp()
    {
        if ($messageTransformer = config('musonza_chat.transformers.message')) {
            $this->messageTransformer = app($messageTransformer);
        }
    }

    private function itemResponse($message)
    {
        if ($this->messageTransformer) {
            return fractal($message, $this->messageTransformer)->respond();
        }

        return response($message);
    }

    public function store(StoreMessage $request,
                          $conversationId,
                          BotServices $botServices,
                          WhatsAppServiceApi $whatsAppServiceApi)
    {
        $conversation = Chat::conversations()->getById($conversationId);
        $message = Chat::message($request->getMessageBody())
            ->from($request->getParticipant())
            ->to($conversation)
            ->send();

        $botServices->sendWhatsAppReply($conversation, $request->getMessageBody(), $whatsAppServiceApi);

        return $this->itemResponse($message);
    }
}
