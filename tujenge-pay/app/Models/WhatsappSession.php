<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class WhatsappSession extends Model
{
    use Uuids;

    protected $connection = 'mysql';

    protected $table = 'whatsapp_sessions';

    public $incrementing = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bot_session(){

        return $this->belongsTo(BotSession::class);
    }

}
