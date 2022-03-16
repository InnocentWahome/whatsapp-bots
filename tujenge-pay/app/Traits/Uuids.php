<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/8/17
 * Time: 9:52 AM
 */

namespace App\Traits;


use Webpatser\Uuid\Uuid;

trait Uuids
{
    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }
}