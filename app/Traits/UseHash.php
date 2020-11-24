<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait UseHash
{
    public static function bootUseHash()
    {
        static::creating(function ($model) {
            $model->hash = Uuid::uuid4();
        });
    }
}