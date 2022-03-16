<?php


namespace App\Services;


use App\Jobs\Queue;
use App\Models\BotConversation;
use App\Models\MasterMemberList;
use App\Models\TelegramAccount;
use App\Models\WhatsappAccount;
use App\Models\WhatsappOtpCode;
use App\Notifications\SendMpesaNumberTwoFactorCode;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Chat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Musonza\Chat\Models\Conversation;
use Musonza\Chat\Tests\Helpers\Models\Bot;

class BotServices
{
    public function saveInputToDb($input, $bot_step)
    {

    }

    public function queryAndValidateMembershipNo($input)
    {
        $client = new Client();

        $response = $client->request('POST', env('POLICY_VALIDATION_URL'), [
            'timeout' => 45, // Response timeout
            'connect_timeout' => 30, // Connection timeout
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'policy_no' => $input,
            ])
        ]);

        $array_response = (array)json_decode($response->getBody());

        return $array_response['result'];
    }

    public function sendOtp($whatsapp_number)
    {

        $otp_codes = WhatsappOtpCode::where('phone_number', $whatsapp_number)
            ->where('status', 'active')
            ->get();

        foreach ($otp_codes as $otp_code) {

            $otp_code->status = 'inactive';

            $otp_code->save();
        }

        $whatsapp_otp_code = new WhatsappOtpCode();

        $whatsapp_otp_code->phone_number = $whatsapp_number;
        $whatsapp_otp_code->code = rand(10000, 99999);
        $whatsapp_otp_code->expires_at = Carbon::now()->addHours(2);

        $whatsapp_otp_code->save();

        $sms_number = substr($whatsapp_number, 1);

        $whatsapp_otp_code->notify(new SendMpesaNumberTwoFactorCode($whatsapp_otp_code->code, $sms_number));

    }

    public function confirmOtp($whatsapp_number, $code, $channel)
    {

        if (WhatsappOtpCode::where('phone_number', $whatsapp_number)->where('code', $code)
            ->where('status', 'active')
            ->exists()) {

            $latest_code = WhatsappOtpCode::where('phone_number', $whatsapp_number)
                ->where('code', $code)
                ->where('status', 'active')
                ->sharedLock()->latest()->first();

//            $latest_code->status = 'inactive';

//            $latest_code->save();

            return true;
        }

        return false;

//        $client = new Client();
//
//        if ($channel == env('WHATSAPP_CHANNEL')) {
//            $body = json_encode([
//                'channel' => $channel,
//                'message' => $code,
//                'whatsapp_number' => $whatsapp_number
//            ]);
//        }
//
//        if ($channel == env('TELEGRAM_CHANNEL')) {
//            $body = json_encode([
//                'channel' => $channel,
//                'message' => $code,
//                'telegram_chat_id' => $whatsapp_number
//            ]);
//        }
//
//        if ($channel == env('MESSENGER_CHANNEL')) {
//            $body = json_encode([
//                'channel' => $channel,
//                'message' => $code,
//                'messenger_sender_id' => $whatsapp_number
//            ]);
//        }
//
//        $response = $client->request('POST', env('CONFIRM_DOB_URL'), [
//            'timeout' => 45, // Response timeout
//            'connect_timeout' => 30, // Connection timeout
//            'headers' => [
//                'Content-Type' => 'application/json',
//            ],
//            'body' => $body
//        ]);
//
//        $array_response = (array)json_decode($response->getBody());
//
//        $result = $array_response['result'];
//
//        if($result){
//
//            return true;
//        }
//
//        return false;
    }

    public function confirmOtpAgain($whatsapp_number)
    {
        if(WhatsappOtpCode::where('phone_number', $whatsapp_number)
            ->where('status', 'active')
            ->exists()){

            $botServices = new BotServices();

            $botServices->sendOtp($whatsapp_number);

            return false;
        }

        return true;
    }

    public function updateWhatsAppMembershipNo($whatsapp_number, $membership_no, $channel)
    {

        $client = new Client();

        if ($channel == env('WHATSAPP_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'membership_no' => $membership_no,
                'whatsapp_number' => $whatsapp_number
            ]);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'membership_no' => $membership_no,
                'telegram_chat_id' => $whatsapp_number
            ]);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'membership_no' => $membership_no,
                'messenger_sender_id' => $whatsapp_number
            ]);
        }

        $response = $client->request('POST', env('MEMBERSHIP_UPDATE_URL'), [
            'timeout' => 45, // Response timeout
            'connect_timeout' => 30, // Connection timeout
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $body
        ]);

        $array_response = (array)json_decode($response->getBody());

        return $array_response['result'];
    }

    public function queryBalances($whatsapp_number, $channel, $message_type)
    {

        $client = new Client();

        if ($channel == env('WHATSAPP_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'whatsapp_number' => $whatsapp_number,
            ]);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'telegram_chat_id' => $whatsapp_number,
            ]);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'messenger_sender_id' => $whatsapp_number,
            ]);
        }


        dispatch(new Queue($body, $channel, $whatsapp_number, $message_type));

        return 'Please wait..';
    }

    public function queryCover($whatsapp_number, $channel, $message_type)
    {

        if ($channel == env('WHATSAPP_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'whatsapp_number' => $whatsapp_number,
            ]);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'telegram_chat_id' => $whatsapp_number,
            ]);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'messenger_sender_id' => $whatsapp_number,
            ]);
        }

        dispatch(new Queue($body, $channel, $whatsapp_number, $message_type));

        return 'Please wait...';
    }

    public function queryUtilization($whatsapp_number, $channel, $message_type)
    {
        if ($channel == env('WHATSAPP_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'whatsapp_number' => $whatsapp_number,
            ]);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'telegram_chat_id' => $whatsapp_number,
            ]);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'messenger_sender_id' => $whatsapp_number,
            ]);
        }

        dispatch(new Queue($body, $channel, $whatsapp_number, $message_type));

        return 'Please wait...';
    }

    public function queryPolicyStatement($whatsapp_number, $message, $message_type, $channel)
    {
        if ($channel == env('WHATSAPP_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'whatsapp_number' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'telegram_chat_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'messenger_sender_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        dispatch(new Queue($body, $channel, $whatsapp_number, $message_type));

        return 'Please wait...';
    }

    public function saveQuote($whatsapp_number,
                              $channel,
                              $message,
                              $message_type)
    {

        $client = new Client();

        if ($channel == env('WHATSAPP_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'whatsapp_number' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'telegram_chat_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'messenger_sender_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        $response = $client->request('POST', env('SAVE_QUOTE_URL'), [
            'timeout' => 45, // Response timeout
            'connect_timeout' => 30, // Connection timeout
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $body
        ]);

        $array_response = (array)json_decode($response->getBody());

        return $array_response['result'];
    }

    public function checkIfMembershipIsset($whatsapp_number,
                                           $channel,
                                           $message,
                                           $message_type)
    {

        $client = new Client();

        if ($channel == env('WHATSAPP_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'whatsapp_number' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'telegram_chat_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'messenger_sender_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        $response = $client->request('POST', env('CHECK_MEMBERSHIP_NO_URL'), [
            'timeout' => 45, // Response timeout
            'connect_timeout' => 30, // Connection timeout
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $body
        ]);

        $array_response = (array)json_decode($response->getBody());

        return $array_response['result'];
    }

    public function calculatePremiumBalance($whatsapp_number,
                                            $channel,
                                            $message,
                                            $message_type)
    {

        $client = new Client();

        if ($channel == env('WHATSAPP_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'whatsapp_number' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'telegram_chat_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'messenger_sender_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        $response = $client->request('POST', env('CALCULATE_PREMIUM_BAL_URL'), [
            'timeout' => 45, // Response timeout
            'connect_timeout' => 30, // Connection timeout
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $body
        ]);

        $array_response = (array)json_decode($response->getBody());

        return $array_response['result'];
    }

//    public function makePayment($whatsapp_number,
//                                $channel,
//                                $message,
//                                $message_type){
//
//        $client = new Client();
//
//        $response = $client->request('POST', env('CALCULATE_PREMIUM_BAL_URL'), [
//            'timeout' => 45, // Response timeout
//            'connect_timeout' => 30, // Connection timeout
//            'headers' => [
//                'Content-Type' => 'application/json',
//            ],
//            'body' => json_encode([
//                'channel' => $channel,
//                'whatsapp_number' => $whatsapp_number,
//                'message' => $message,
//                'message_type' => $message_type
//            ])
//        ]);
//
//        $array_response = (array)json_decode($response->getBody());
//
//        return $array_response['result'];
//
//    }

    public function checkMpesaNumber($whatsapp_number,
                                     $channel,
                                     $message,
                                     $message_type)
    {

        $client = new Client();

        if ($channel == env('WHATSAPP_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'whatsapp_number' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'telegram_chat_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'messenger_sender_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        $response = $client->request('POST', env('CHECK_MPESA_NO'), [
            'timeout' => 45, // Response timeout
            'connect_timeout' => 30, // Connection timeout
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $body
        ]);

        $array_response = (array)json_decode($response->getBody());

        return $array_response['result'];
    }

    public function storeMpesaNumber($whatsapp_number,
                                     $channel,
                                     $message,
                                     $message_type)
    {

        $client = new Client();

        if ($channel == env('WHATSAPP_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'whatsapp_number' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'telegram_chat_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'messenger_sender_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        $response = $client->request('POST', env('SAVE_MPESA_NUMBER'), [
            'timeout' => 45, // Response timeout
            'connect_timeout' => 30, // Connection timeout
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $body
        ]);

        $array_response = (array)json_decode($response->getBody());

        return $array_response['result'];
    }

    public function paymentAmount($whatsapp_number,
                                  $channel,
                                  $message,
                                  $message_type)
    {

        $client = new Client();

        if ($channel == env('WHATSAPP_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'whatsapp_number' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'telegram_chat_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'messenger_sender_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        $response = $client->request('POST', env('PUSH_STK'), [
            'timeout' => 45, // Response timeout
            'connect_timeout' => 30, // Connection timeout
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $body
        ]);

        $array_response = (array)json_decode($response->getBody());

        return $array_response['result'];
    }

    public function handleCustomerCare($whatsapp_number,
                                       $message,
                                       $message_type,
                                       $channel
    )
    {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            $bot_account = WhatsappAccount::where('phone_number', $whatsapp_number)
                ->first();

            $participants = [\App\User::where('email', 'karokijames40@gmail.com')->first(), \App\Models\WhatsappAccount::where('phone_number', $whatsapp_number)->first()];
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            $bot_account = TelegramAccount::where('chat_id', $whatsapp_number)
                ->first();

            $participants = [\App\User::where('email', 'karokijames40@gmail.com')->first(), TelegramAccount::where('chat_id', $whatsapp_number)->first()];
        }


        if ($message == 2) {

            if (BotConversation::where('bot_account_id', $bot_account->id)->exists()) {

                $bot_conversation = BotConversation::where('bot_account_id', $bot_account->id)->first();

                $conversation = Conversation::where('id', $bot_conversation->conversation_id)->first();

                Chat::message($message)
                    ->from($bot_account)
                    ->to($conversation)
                    ->send();

            } else {

                $conversation = Chat::createConversation($participants);

                $bot_conversation = new BotConversation();

                $bot_conversation->bot_account_id = $bot_account->id;
                $bot_conversation->channel = $channel;
                $bot_conversation->conversation_id = $conversation->id;

                $bot_conversation->save();

                Chat::message($message)
                    ->from($bot_account)
                    ->to($conversation)
                    ->send();
            }

        }

//        return "Hi, thanks we've received your request, our customer care agent will get back to you shortly";

        return false;

    }

    public function replyCustomerCare($whatsapp_number,
                                      $message,
                                      $message_type,
                                      $channel
    )
    {

        if ($channel == env('WHATSAPP_CHANNEL')) {

            $bot_account = WhatsappAccount::where('phone_number', $whatsapp_number)
                ->first();

            $participants = [\App\User::where('email', 'karokijames40@gmail.com')->first(), \App\Models\WhatsappAccount::where('phone_number', $whatsapp_number)->first()];
        }


        if (BotConversation::where('bot_account_id', $bot_account->id)->exists()) {

            $bot_conversation = BotConversation::where('bot_account_id', $bot_account->id)->first();

            $conversation = Conversation::where('id', $bot_conversation->conversation_id)->first();

            Chat::message($message)
                ->from($bot_account)
                ->to($conversation)
                ->send();

        } else {

            $conversation = Chat::createConversation($participants);

            $bot_conversation = new BotConversation();

            $bot_conversation->bot_account_id = $bot_account->id;
            $bot_conversation->channel = $channel;
            $bot_conversation->conversation_id = $conversation->id;

            $bot_conversation->save();

            Chat::message($message)
                ->from($bot_account)
                ->to($conversation)
                ->send();
        }
    }

    public function sendWhatsAppReply($conversation, $body, WhatsAppServiceApi $whatsAppServiceApi){

        $bot_conversation = BotConversation::where('conversation_id', $conversation->id)->first();

        if($bot_conversation->channel == env('WHATSAPP_CHANNEL')){

            $whatsapp_account = WhatsappAccount::where('id', $bot_conversation->bot_account_id)->first();

            if (env('WA_BOT_ENV') == 'TWILIO') {
                // TWILIO API CREDENTIALS
                $sid = env('TWILIO_SID');
                $token = env('TWILIO_TOKEN');

                // The TujengePay WhatsApp number
                $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

                // Initialize the Twilio Client
                $twilio = new \Twilio\Rest\Client($sid, $token);

                $message = $twilio->messages
                    ->create("whatsapp:" . $whatsapp_account->phone_number,
                        array(
                            "body" => $body,
                            "from" => "whatsapp:" . $whatsapp_live_number
                        )
                    );
            }

            if (env('WA_BOT_ENV') == '360') {


                $whatsAppServiceApi->send('text', substr($whatsapp_account->phone_number, 1), $body, 'individual', false);
            }
        }

    }

    public function selectLetter($whatsapp_number,
                                   $message,
                                   $message_type,
                                   $channel
    )
    {
        $client = new Client();

        if ($channel == env('WHATSAPP_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'whatsapp_number' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'telegram_chat_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'messenger_sender_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        $response = $client->request('POST', env('SAVE_LETTER_URL'), [
            'timeout' => 45, // Response timeout
            'connect_timeout' => 30, // Connection timeout
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $body
        ]);

        $array_response = (array)json_decode($response->getBody());

        return $array_response['result'];

    }

    public function saveLetter($whatsapp_number,
                               $message,
                               $message_type,
                               $channel)
    {

        $client = new Client();

        if ($channel == env('WHATSAPP_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'whatsapp_number' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'telegram_chat_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'messenger_sender_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        $response = $client->request('POST', env('SAVE_LETTER_URL'), [
            'timeout' => 45, // Response timeout
            'connect_timeout' => 30, // Connection timeout
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $body
        ]);

        $array_response = (array)json_decode($response->getBody());

        return $array_response['result'];
    }

    public function downloadLetter($whatsapp_number,
                                      $message,
                                      $message_type,
                                      $channel
    )
    {
        $client = new Client();

        if ($channel == env('WHATSAPP_CHANNEL')) {
            $body = json_encode([
                'channel' => $channel,
                'whatsapp_number' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('TELEGRAM_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'telegram_chat_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        if ($channel == env('MESSENGER_CHANNEL')) {

            $body = json_encode([
                'channel' => $channel,
                'messenger_sender_id' => $whatsapp_number,
                'message' => $message,
                'message_type' => $message_type
            ]);
        }

        $response = $client->request('POST', env('DOWNLOAD_LETTER_URL'), [
            'timeout' => 45, // Response timeout
            'connect_timeout' => 30, // Connection timeout
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $body
        ]);

        $array_response = (array)json_decode($response->getBody());

        return $array_response['result'];
    }

}
