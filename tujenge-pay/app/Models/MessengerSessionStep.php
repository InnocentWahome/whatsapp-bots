<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class MessengerSessionStep extends Model
{
    use Uuids;

    public $incrementing = false;

    protected $connection = 'mysql';

    protected $table = 'messenger_session_steps';

    public function bot_session_step(){

        return $this->belongsTo(BotSessionStep::class);
    }
}
