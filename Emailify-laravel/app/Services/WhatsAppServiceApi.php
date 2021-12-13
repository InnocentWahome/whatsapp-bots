<?php


namespace App\Services;


use GuzzleHttp\Client;

class WhatsAppServiceApi
{

    public function send($type, $to, $message, $recipient_type, $preview_url){

        $client = new Client();

        $response = $client->request('POST', 'https://waba.360dialog.io/v1/messages', [

            'headers' => [
                'Content-Type' => 'application/json',
                'D360-API-KEY' => 'BFA39DlBEFUc5Es07sVHpgqUAK',
            ],

            'body' => json_encode([
                'preview_url' => $preview_url,
                'recipient_type' => $recipient_type,
                'to' => $to,
                'type' => $type,
                'text' => [
                    'body' => $message
                ]
            ])
        ]);

        $data = (array) json_decode($response->getBody());

        return $data;
    }

    public function sendTemplate($to, $namespace, $element_name, $param_1, $param_2){

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://waba.360dialog.io/v1/messages', [

            'headers' => [
                'Content-Type' => 'application/json',
                'D360-API-KEY' => 'BFA39DlBEFUc5Es07sVHpgqUAK'
            ],

            'body' => json_encode([
                'to' => $to,
                'ttl'=> '86400',
                'type' => 'hsm',
                'hsm' => [
                    'namespace' => $namespace,
                    'element_name' => $element_name,
                    'language' => [
                        'policy' => 'deterministic',
                        'code' => 'en'
                    ],
                    'localizable_params'=> [
                        [ 'default' => $param_1 ],
                        [ 'default' => $param_2 ]
                    ]
                ]
            ])
        ]);

        $data = (array) json_decode($response->getBody());

        return $data;
    }

    public function sendImage($type, $to, $message, $recipient_type, $preview_url, $image_url){

        $client = new Client();

        $response = $client->request('POST', 'https://waba.360dialog.io/v1/messages', [

            'headers' => [
                'Content-Type' => 'application/json',
                'D360-API-KEY' => 'BFA39DlBEFUc5Es07sVHpgqUAK',
            ],

            'body' => json_encode([
                'preview_url' => $preview_url,
                'recipient_type' => $recipient_type,
                'to' => $to,
                'type' => $type,
                'image' => [
                    'link' => $image_url,
                    'provider' => [
                        'name' => null
                    ],
                    'caption' => $message
                ]
            ])
        ]);

        $data = (array) json_decode($response->getBody());

        return $data;
    }

    public function sendVideo($type, $to, $message, $recipient_type, $preview_url, $image_url){

        $client = new Client();

        $response = $client->request('POST', 'https://waba.360dialog.io/v1/messages', [

            'headers' => [
                'Content-Type' => 'application/json',
                'D360-API-KEY' => 'BFA39DlBEFUc5Es07sVHpgqUAK',
            ],

            'body' => json_encode([
                'preview_url' => $preview_url,
                'recipient_type' => $recipient_type,
                'to' => $to,
                'type' => $type,
                'video' => [
                    'link' => $image_url,
                    'caption' => $message
                ]
            ])
        ]);

        $data = (array) json_decode($response->getBody());

        return $data;
    }

    public function checkContact($whastapp_contact, $blocking, $force_check){
        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://waba.360dialog.io/v1/contacts', [

            'headers' => [
                'Content-Type' => 'application/json',
                'D360-API-KEY' => 'BFA39DlBEFUc5Es07sVHpgqUAK',
            ],

            'body' => json_encode([
                'blocking' => $blocking,
                'contacts' => [
                    $whastapp_contact,
                ],
                'force_check' => $force_check
            ])
        ]);

        $data = (array) json_decode($response->getBody());

       return $data;
    }

}
