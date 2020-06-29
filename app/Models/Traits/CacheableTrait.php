<?php

namespace App\Models\Traits;

use Cache;
use Illuminate\Database\Eloquent\Model;

trait CacheableTrait
{
    public static function bootCacheableTrait()
    {
        static::creating(function () {
            Cache::tags([
                \App\Models\Interfaces\Contentable::CONTENT,
                static::CACHE_TAGS
            ])
                ->flush();
        });

        static::updating(function (Model $model) {
            Cache::tags([
                \App\Models\Interfaces\Contentable::CONTENT,
                static::CACHE_TAGS,
                static::class . $model->id
            ])
                ->flush();
        });

        static::deleting(function (Model $model) {
            Cache::tags([
                \App\Models\Interfaces\Contentable::CONTENT,
                static::CACHE_TAGS,
                static::class . $model->id
            ])
                ->flush();
        });

    }
}
