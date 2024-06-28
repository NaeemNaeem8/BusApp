<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory,HasUlids,SoftDeletes;

    protected $guarded = [];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                return Carbon::parse($value)->format('Y-m-d');
            }
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                return Carbon::parse($value)->format('Y-m-d');
            }
        );
    }
}
