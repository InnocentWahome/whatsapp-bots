<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class WhatsappSessionStep extends Model
{

    use Uuids;

    protected $table = 'whatsapp_session_steps';

    public $incrementing = false;

    protected $connection = 'mysql';

    public function bot_session_step(){

        return $this->belongsTo(BotSessionStep::class);
    }


}
