<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
class Line extends Model
{
    use HasFactory,HasUlids,SoftDeletes;
    protected $guarded = [];

    /**
     * Get all of the line_parkings for the Line
     *
     * @return \
     */
    public function line_parkings(): HasManyThrough
    {
        return $this->hasManyThrough(LineParking::class, LineTrip::class);
    }
}
