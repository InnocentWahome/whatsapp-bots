<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSessionStep extends Model
{
    use HasFactory;

    protected $table = 'user_session_steps';

    public function user(){
        return $this->belongsTo(User::class);
    }
}
