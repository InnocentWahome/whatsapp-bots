<?php


namespace App\Services;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WhatsAppServiceApi
{

    public function send($type, $to, $message, $recipient_type, $preview_url)
    {

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

        $data = (array)json_decode($response->getBody());

        return $data;
    }

    public function sendTemplate($to, $namespace, $element_name, $param_1, $param_2)
    {

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://waba.360dialog.io/v1/messages', [

            'headers' => [
                'Content-Type' => 'application/json',
                'D360-API-KEY' => 'BFA39DlBEFUc5Es07sVHpgqUAK'
            ],

            'body' => json_encode([
                'to' => $to,
                'ttl' => '86400',
                'type' => 'hsm',
                'hsm' => [
                    'namespace' => $namespace,
                    'element_name' => $element_name,
                    'language' => [
                        'policy' => 'deterministic',
                        'code' => 'en'
                    ],
                    'localizable_params' => [
                        ['default' => $param_1],
                        ['default' => $param_2]
                    ]
                ]
            ])
        ]);

        $data = (array)json_decode($response->getBody());

        return $data;
    }

    public function sendImage($type, $to, $message, $recipient_type, $preview_url, $image_url)
    {

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

        $data = (array)json_decode($response->getBody());

        return $data;
    }

    public function sendFile($type, $to, $message, $recipient_type, $file_url)
    {

        $client = new Client();

        $response = $client->request('POST', 'https://waba.360dialog.io/v1/messages', [

            'headers' => [
                'Content-Type' => 'application/json',
                'D360-API-KEY' => 'BFA39DlBEFUc5Es07sVHpgqUAK',
            ],

            'body' => json_encode([
                'recipient_type' => $recipient_type,
                'to' => $to,
                'type' => $type,
                "document" => [
                    "link" => $file_url,
                    "caption" => $message
                ]
            ])
        ]);

        $data = (array)json_decode($response->getBody());

        return $data;
    }

    public function sendVideo($type, $to, $message, $recipient_type, $preview_url, $image_url)
    {

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

        $data = (array)json_decode($response->getBody());

        return $data;
    }

    public function checkContact($whastapp_contact, $blocking, $force_check)
    {
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

        $data = (array)json_decode($response->getBody());

        return $data;
    }

    public function sendInteractiveButton($to, $buttons, $body_text)
    {

        try {
            $client = new \GuzzleHttp\Client();

            $response = $client->request('POST', 'https://waba.360dialog.io/v1/messages', [

                'headers' => [
                    'Content-Type' => 'application/json',
                    'D360-API-KEY' => 'BFA39DlBEFUc5Es07sVHpgqUAK'
                ],

                'body' => json_encode([
                    "recipient_type" => "individual",
                    "to" => $to,
                    "type" => "interactive",
                    "interactive" => [
                        "type" => "button",
//                    "header" => [
//                        "type" => "text",
//                        "text" => ""
//                    ],
                        "body" => [
                            "text" => $body_text
                        ],
//                    "footer" => [
//                        "text" => "your-footer-content"
//                    ],
                        "action" => [
                            'buttons' => $buttons
                        ] # end action
                    ]])
            ]);

            $data = (array)json_decode($response->getBody());

            return $data;
        } catch (\Exception $exception) {
            // this is the new custom handling of guzzle exceptions
            if ($exception instanceof \GuzzleHttp\Exception\RequestException) {
                // get the full text of the exception (including stack trace),
                // and replace the original message (possibly truncated),
                // with the full text of the entire response body.
                if ($exception != null) {
                    if ($exception->getResponse() != null) {
                        $message = str_replace(
                            rtrim($exception->getMessage()),
                            (string)$exception->getResponse()->getBody(),
                            (string)$exception
                        );

                        Log::info('ERROR MESSAGE API : ' . $message);

                        dd($message);
                    } else {
                        Log::info('ERROR MESSAGE API GET RESPONSE IS NULL :' . $exception->getResponse());
                    }
                }

            }
        }

    }

    public function sendInteractiveList($to, $sections, $body_text)
    {

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://waba.360dialog.io/v1/messages', [

            'headers' => [
                'Content-Type' => 'application/json',
                'D360-API-KEY' => 'BFA39DlBEFUc5Es07sVHpgqUAK'
            ],

            'body' => json_encode([
                "recipient_type" => "individual",
                "to" => $to,
                "type" => "interactive",
                "interactive" => [
                    "type" => "list",
//                    "header" => [
//                        "type" => "text",
//                        "text" => "your-header-content"
//                    ],
                    "body" => [
                        "text" => $body_text
                    ],
//                    "footer" => [
//                        "text" => "your-footer-content"
//                    ],
                    "action" => [
                        "button" => "Click here",
                        'sections' => $sections
                    ] # end action
                ]])
        ]);

        $data = (array)json_decode($response->getBody());

        return $data;
    }



}
