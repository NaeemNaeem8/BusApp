<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripSupervisor extends Model
{
    use HasFactory,HasUlids,SoftDeletes,\Znck\Eloquent\Traits\BelongsToThrough;
    protected $guarded = [];

    public function line_trip()
    {
        return $this->belongsToThrough(LineTrip::class, LineParking::class);
    }
}
