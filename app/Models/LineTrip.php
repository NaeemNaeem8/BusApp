<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LineTrip extends Model
{
    use HasFactory, HasUlids, SoftDeletes, \Znck\Eloquent\Traits\BelongsToThrough;
    protected $guarded = [];


    ###############################   This relations for create only  ###############################
    public function drivers_buses(): HasMany
    {
        return $this->hasMany(TripBus::class, 'line_trip_id');
    }

    public function supervisors(): HasMany
    {
        return $this->hasMany(TripSupervisor::class, 'line_trip_id');
    }

    public function parkings(): HasMany
    {
        return $this->hasMany(LineParking::class, 'line_trip_id');
    }
    ###############################   End create relations ###############################
    public function line(): BelongsTo
    {
        return $this->belongsTo(Line::class, 'line_id');
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function day()
    {
        return $this->belongsToThrough(Day::class, Trip::class);
    }
}
