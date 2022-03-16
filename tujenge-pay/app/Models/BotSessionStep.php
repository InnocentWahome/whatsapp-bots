<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class BotSessionStep extends Model
{
    use Uuids;

    public $incrementing = false;

    protected $connection = 'mysql';

    protected $table = 'bot_session_steps';
}
