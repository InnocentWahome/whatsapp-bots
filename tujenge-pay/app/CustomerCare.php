<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CustomerCare extends Model
{
    use Notifiable;

    public $email = 'callcentre@aar.co.ke';
}
