<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
    use HasFactory,HasApiTokens,HasUlids,SoftDeletes;

    protected $hidden = [
        'password',
    ];

    protected $guarded = [];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if (trim($value) === '')
                    return;
                return bcrypt($value);
            }
        );
    }
}
