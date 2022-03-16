<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class WhatsappOtpCode extends Model
{
    use Notifiable;

    protected $connection = 'mysql';

    protected $table = 'whatsapp_otp_codes';
}
