<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class University extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $guarded = [];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all of the bookings for the University
     *
     * @return \
     */
    public function bookings(): HasManyThrough
    {
        return $this->hasManyThrough(Booking::class, User::class);
    }
}
