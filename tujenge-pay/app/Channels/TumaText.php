<?php

namespace App\Channels;

/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/22/17
 * Time: 12:12 PM
 */

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;

use App\Sms\AfricasTalkingGateway;
use App\Sms\AfricasTalkingGatewayException;


class TumaText
{
    public function send($notifiable, Notification $notification){

        $message = $notification->toTumaText($notifiable);

        try {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://chatway.co.ke/account/api/v1/sendsms',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('to' => $message['numbers'],'message' => $message['message']),
                CURLOPT_HTTPHEADER => array( 'Authorization: Bearer d373b4f46a307e6a6cff6526343c06ca:cf89f7-e865c4-c266ba-005aeb-c44b09'
                ), ));
            $response = curl_exec($curl); curl_close($curl);
        }catch (\Exception $exception){

            $client = new Client();

            $password = base64_encode('karoki@tujenge.io:Tuj3ng3P@y!');

            $response = $client->request('POST', 'https://ext1.tumatext.co.ke/ext/ordersms', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . $password
                ],
                'body' => json_encode([
                    "messages" => [
                        [
                            "to" => $message['numbers'],
                            "text" => $message['message']
                        ]
                    ]
                ])
            ]);

            $array_response = (array)json_decode($response->getBody());
        }
    }
}
