<?php

namespace App\Rules;

use App\Models\TripBus;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class TripBusesRule implements Rule
{

    public function __construct(
        public array $drivers,
        public array $buses,
        public string $line_trip_id
    ) {
        //
    }

    public function passes($attribute, $value)
    {
        return TripBus::where(fn ($q) => $q->busesExists($this->buses, $this->line_trip_id)) 
            ->orWhere(fn ($q) => $q->driversExists($this->drivers, $this->line_trip_id)) 
            ->count() === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message trip_buses.';
    }
}
