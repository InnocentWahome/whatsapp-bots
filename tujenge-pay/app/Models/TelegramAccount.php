<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Musonza\Chat\Traits\Messageable;

class TelegramAccount extends Model
{
    use Uuids;

    public $incrementing = false;

    protected $connection = 'mysql';

    protected $table = 'telegram_accounts';

    use Messageable;

}
