<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class BotResponse extends Model
{
    use Uuids;

    public $incrementing = false;

    protected $connection = 'mysql';

    protected $table = 'bot_responses';
}
