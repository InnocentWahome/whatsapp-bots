<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestAaarModel extends Model
{
    protected $connection = 'mysql';

    protected $table = 'dbo.MASTER_MEMBER_LIST';
}
