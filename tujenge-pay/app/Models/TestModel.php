<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'dbo.MASTER_MEMBER_LIST';

}
