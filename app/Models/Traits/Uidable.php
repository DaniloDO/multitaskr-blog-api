<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait Uidable
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function bootUidable() 
    {
        static::creating(function($model) {
            $model->uid = Str::uuid();
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uid';
    }
}