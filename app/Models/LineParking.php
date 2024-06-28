<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LineParking extends Model
{
    use HasFactory,HasUlids,SoftDeletes;
    protected $guarded = [];


    public function line_trip(): BelongsTo
    {
        return $this->belongsTo(LineTrip::class);
    }

    public function parking(): BelongsTo
    {
        return $this->belongsTo(Parking::class);
    }


    public function trip_buses(): HasMany
    {
        return $this->hasMany(TripBus::class);
    }

    public function trip_supervisors(): HasMany
    {
        return $this->hasMany(TripSupervisor::class);
    }


    public function buses(): BelongsToMany
    {
        return $this->belongsToMany(Bus::class, 'trip_buses', 'line_parking_id', 'bus_id');
    }

    /**
     * Get all of the comments for the LineParking
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
