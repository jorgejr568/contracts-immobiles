<?php

namespace App\Models;

use Illuminate\Support\Str;

trait UuidModel
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}
