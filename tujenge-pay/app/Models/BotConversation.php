<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class BotConversation extends Model
{
    use Uuids;

    protected $connection = 'mysql';

    protected $table = 'bot_conversations';

    public $incrementing = false;

}
