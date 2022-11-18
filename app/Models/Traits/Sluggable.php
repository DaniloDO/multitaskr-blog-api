<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait Sluggable
{

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function bootSluggable()
    {
        static::creating(function($model) {
            $value = $model->{$model->slug()};
            $model->slug = Str::slug($value);
        });
    }

}