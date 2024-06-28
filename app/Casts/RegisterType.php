<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class RegisterType implements CastsAttributes
{

    public function get($model, $key, $value, $attributes): string
    {
        if ($value)
            return 'يومي';
        return 'فصلي';
    }

    public function set($model, $key, $value, $attributes): bool
    {
        if ($value == 'daily')
            return true;

        elseif ($value == 'session')
            return false;
    }
}
