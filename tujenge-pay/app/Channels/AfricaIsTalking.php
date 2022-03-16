<?php

namespace App\Channels;

/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/22/17
 * Time: 12:12 PM
 */

use Illuminate\Notifications\Notification;

use App\Sms\AfricasTalkingGateway;
use App\Sms\AfricasTalkingGatewayException;


class AfricaIsTalking
{
    public function send($notifiable, Notification $notification){

        $message = $notification->toAfricaIsTalking($notifiable);

        //TODO: Move api keys to .env file
        //dd($message['numbers']);

        // Specify your login credentials
        $username   = "TujengePay";
        //Production Key
        $apikey     = "8d38d9e99431e2bf31089f3617985107cea686b3054e7a9eb721710274e2e62e";

        // Sandbox Key
//        $apikey     = "1efba7e147090918f3cdfbf6411b47e45592aa19048ddf533ad9d456d3b18eff";
// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)
        $recipients = $message['numbers'];
// And of course we want our recipients to know what we really do
        $message    = $message['message'];
// Create a new instance of our awesome gateway class
        $gateway    = new AfricasTalkingGateway($username, $apikey);
// Any gateway error will be captured by our custom Exception class below,
// so wrap the call in a try-catch block
        try
        {
            // Thats it, hit send and we'll take care of the rest.
            $results = $gateway->sendMessage($recipients, $message, 'TujengePay');

//            foreach($results as $result) {
//                // status is either "Success" or "error message"
//                echo " Number: " .$result->number;
//                echo " Status: " .$result->status;
//                echo " MessageId: " .$result->messageId;
//                echo " Cost: "   .$result->cost."\n";
//            }
        }
        catch ( AfricasTalkingGatewayException $e )
        {
//            echo "Encountered an error while sending: ".$e->getMessage();
        }
    }
}