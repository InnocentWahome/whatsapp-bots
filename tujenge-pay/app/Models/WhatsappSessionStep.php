<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class WhatsappSessionStep extends Model
{

    use Uuids;

    protected $connection = 'mysql';

    protected $table = 'whatsapp_session_steps';

    public $incrementing = false;

    public function bot_session_step(){

        return $this->belongsTo(BotSessionStep::class);
    }


}
