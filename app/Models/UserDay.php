<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class UserDay extends Model
{
    use HasFactory,HasUlids;

    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class, 'day_id');
    }
    protected $guarded = [];
}
