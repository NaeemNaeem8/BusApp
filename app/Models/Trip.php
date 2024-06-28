<?php

namespace App\Models;

use App\Casts\TripType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $guarded = [];

    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class)->withTrashed();
    }

    public function trips(): HasMany
    {
        return $this->hasMany(LineTrip::class, 'trip_id');
    }

    public function lines(): BelongsToMany
    {
        return $this->belongsToMany(Line::class, 'line_trips', 'trip_id', 'line_id')
            ->withPivot('id');
    }

    protected $casts = [
        'type'          => TripType::class,
        'trip_start'    => 'datetime:H:i A',
        'created_at'    => 'datetime:Y-m-d',
        'updated_at'    => 'datetime:Y-m-d',
    ];
    public static function is_completed()
    {
        return  [
            'line',
            'parkings' => [
                'parking',
                'trip_buses:id,line_parking_id',
                'trip_supervisors:id,line_parking_id'
            ]
        ];
    }
}
