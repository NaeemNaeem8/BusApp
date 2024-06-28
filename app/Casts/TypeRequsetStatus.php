<?php

namespace App\Casts;

use App\Models\TypeRequest;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class TypeRequsetStatus implements CastsAttributes
{

    public function get($model, $key, $value, $attributes): string
    {
        switch ($value) {
            case TypeRequest::rejected:
                return 'مرفوض';
                break;
            case TypeRequest::pending:
                return 'معلق';
                break;
            case TypeRequest::accepted:
                return 'مقبول';
                break;
            default:
                return 'can\'t proccess';
                break;
        }
    }

    public function set($model, $key, $value, $attributes): int
    {
        if ($value == true)
            return TypeRequest::accepted;

        elseif ($value == false)
            return TypeRequest::rejected;
    }
}
