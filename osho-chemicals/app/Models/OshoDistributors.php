<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OshoDistributors extends Model
{
    use HasFactory;
    protected $fillable = [
        'distributorName',
        'countyDimension',
        'phoneNumber'
    ];
}
