<?php

namespace App\Models;

use App\Models\BotSessionStep;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class TelegramSessionStep extends Model
{
    use Uuids;

    protected $connection = 'mysql';

    protected $table = 'telegram_session_steps';

    public $incrementing = false;

    public function bot_session_step(){

        return $this->belongsTo(BotSessionStep::class);
    }

}
