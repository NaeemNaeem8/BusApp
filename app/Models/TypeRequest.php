<?php

namespace App\Models;

use App\Casts\TypeRequsetStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeRequest extends Model
{
    use HasFactory, HasUlids;

    protected $guarded  = [];
    public const accepted   = 2;
    public const pending    = 1;
    public const rejected   = 0;

    protected $casts = [
        'status' => TypeRequsetStatus::class,
    ];
}
