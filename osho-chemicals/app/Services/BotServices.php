<?php


namespace App\Services;

use App\Models\Crop;

class BotServices
{
    public function getCrop(){
 //       $reply_message = Crop::select('name')->get();
 $reply_message = Crop::all();
        return $reply_message;
    }
}
