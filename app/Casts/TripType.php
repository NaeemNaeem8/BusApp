<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class TripType implements CastsAttributes
{

    public function get($model, $key, $value, $attributes): string
    {
        if ($value == 'go')
            return 'ذهاب';
        return 'عودة';
    }

    public function set($model, $key, $value, $attributes): string
    {
        return $value;
    }
}
