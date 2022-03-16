<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Email;
use App\Models\County;
use App\Models\Contact;
use App\Models\OshoProduct;
use Illuminate\Http\Request;
use App\Models\WhatsappAccount;
use App\Models\OshoDistributors;
use Illuminate\Support\Facades\Log;

class BotSessionController extends Controller
{

    public function index()
    {

         // View::share('details',Email::latest()->first());
        // View::share('details',Email::all()->sortByDesc('updated_at')->first());

        // if ($service_method->method_type == 'get_supplier') {

        //     if ($message <= County::all()->count()) {

        //         $county = County::where('id', $message)->first();
        //         Log::info('County Info: ' . $county);
        //         $reply_messages = [" ", "Here is a list of Agrovet suppliers\nin " . $county->name . " County.👇🏾\n\n"];

        //         $suppliers = OshoDistributors::where('countyDimension', $county->name)->get();
        //         Log::info("address: " . $suppliers);
        //         Log::info("Count: " . $suppliers->count());

        //         $suppliers_array = $suppliers->toArray();
        //         while (count($suppliers_array)) {
        //             $supplier_chunk = array_chunk($suppliers_array, 8);

        //             foreach ($supplier_chunk as $suppliers) {
        //                 $suppliers_message = " ";
        //                 foreach ($suppliers as $supplier) {
        //                     Log::info("Supplier: " . print_r($supplier, true));
        //                     $suppliers_message .= $supplier["distributorName"] . ":\n" . $supplier["phoneNumber"] . "\n\n";
        //                 }
        //                 array_push($reply_messages, $suppliers_message);
        //             }
        //             break;
        //         }

        //         array_push($reply_messages, "\nType *99* to go back home");
        //     } else {
        //         $reply_message = "Oops🙊wrong option. Type *99* to\ngo back home";

        //         if ($channel == env('WHATSAPP_CHANNEL')) {

        //             if (env('WA_BOT_ENV') == 'TWILIO') {
        //                 // TWILIO API CREDENTIALS
        //                 $sid = 'AC86868678f517b851d044e933039b8a1c';
        //                 $token = '3e5c1042b1c7d6a6e6717e7d9818f38c'; 

        //                 // The TujengePay WhatsApp number
        //                 $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

        //                 // Initialize the Twilio Client
        //                 $twilio = new \Twilio\Rest\Client($sid, $token);

        //                 $message = $twilio->messages
        //                     ->create(
        //                         "whatsapp:" . $user_identifier,
        //                         array(
        //                             "body" => $reply_message,
        //                             "from" => "whatsapp:" . $whatsapp_live_number
        //                         )
        //                     );
        //             }

        //             if (env('WA_BOT_ENV') == '360') {


        //                 $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
        //             }
        //         }
        //     }

        //     if ($channel == env('WHATSAPP_CHANNEL')) {

        //         if (env('WA_BOT_ENV') == 'TWILIO') {
        //             // TWILIO API CREDENTIALS
        //             $sid = 'AC86868678f517b851d044e933039b8a1c';
        //             $token = '3e5c1042b1c7d6a6e6717e7d9818f38c'; 

        //             // The TujengePay WhatsApp number
        //             $whatsapp_live_number = '+14155238886'; //'+254203892383'; //+254203892383 // +14155238886

        //             // Initialize the Twilio Client
        //             $twilio = new \Twilio\Rest\Client($sid, $token);
        //             foreach ($reply_messages as $reply_message) {
        //                 $message = $twilio->messages
        //                     ->create(
        //                         "whatsapp:" . $user_identifier,
        //                         array(
        //                             "body" => $reply_message,
        //                             "from" => "whatsapp:" . $whatsapp_live_number
        //                         )
        //                     );
        //             }
        //         }

        //         if (env('WA_BOT_ENV') == '360') {

        //             foreach ($reply_messages as $reply_message){
        //                 $whatsAppServiceApi->send('text', $message_from, $reply_message, 'individual', false);
        //             }

        //         }
        //     }
        // }
    }

    public function show(Request $request)
    {
        $counties = OshoDistributors::whereNotNull('address1_county')->distinct()->get('address1_county');

        // $co = array($counties);
        $arr = explode(",", $counties);
        return $counties;
        // $co = "";
        // $position = 1;
        // foreach($counties as $county){
        //     $co .= $position." ".$county->address1_county;
        //     $position++;
        // }
        // return $co;
        //
    }

    public function store(Request $request)
    {
        $name = "Mwema";
        session()->put('name', $name);
        echo "Name saved successfully";
    }
}
