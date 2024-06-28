<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
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
