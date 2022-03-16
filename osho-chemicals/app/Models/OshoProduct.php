<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OshoProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'etag',
        'tcc_crop',
        'tcc_product',
        'tcc_targetpest',
        'title',
        'knowledgearticleid'
    ];
}
