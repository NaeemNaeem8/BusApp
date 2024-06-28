<?php

namespace App\Rules;

use App\Models\TripSupervisor;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class TripSupervisorsRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(public string $line_trip_id, public array $ids)
    {
        //
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return TripSupervisor::whereIn('supervisor_id', $this->ids)
            ->whereRelation('line_trip', 'line_trips.id', $this->line_trip_id)
            ->count() === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message trip_supervisors.';
    }
}
