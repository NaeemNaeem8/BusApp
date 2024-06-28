<?php

namespace App\Services;

use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class TripServices
{

    public function search(array $inputs): Collection | array
    {
        if (!$inputs)
            return [];

        $q = Trip::query();

        ##################  search by day ##################
        $q->when(array_key_exists('day_id', $inputs), fn ($q) => $q->where('day_id', $inputs['day_id']));

        ##################  search by trip start ##################
        $q->when(array_key_exists('trip_start', $inputs), fn ($q) => $q->where('trip_start', '>=', Carbon::parse($inputs['trip_start'])->format('H:i')));

        ##################  search by type ##################
        $q->when(array_key_exists('type', $inputs), fn ($q) => $q->where('type', $inputs['type']));

        return $q->with(['day:id,name,deleted_at', 'lines:id,name', 'trips' =>  Trip::is_completed()])
            ->get();
    }

    public function store(array $TripInput, array $lines): void
    {
        $trip =  Trip::create($TripInput);
        $trip->trips()->createMany($lines);
    }
}
