<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripBus extends Model
{
    use HasFactory,HasUlids,SoftDeletes,\Znck\Eloquent\Traits\BelongsToThrough;

    protected $guarded = [];

    public function line_trip()
    {
        return $this->belongsToThrough(LineTrip::class, LineParking::class);
    }

    public function scopeBusesExists($q, array $buses, string $line_trip_id) 
    { 
        return $q->whereIn('bus_id', $buses)-> whereRelation('line_trip', 'line_trips.id', $line_trip_id); 
    } 
 
    public function scopeDriversExists($q, array $drivers, string $line_trip_id) 
    { 
        return $q->whereIn('driver_id', $drivers)->whereRelation('line_trip', 'line_trips.id', $line_trip_id); 
    }
}
