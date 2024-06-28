<?php

namespace App\Rules;

use App\Models\Trip;
use Illuminate\Contracts\Validation\Rule;

class TripExistRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(public $type, public $day_id, public $reqestType = 'post', public $id = null)
    {
        //
    }


    public function passes($attribute, $value)
    {
        if ($this->reqestType === 'post') {
            return Trip::where([
                ['day_id', $this->day_id],
                ['type', $this->type],
                ['trip_start', $value]
            ])->count() == 0;
        } elseif ($this->reqestType === 'update') {
            return Trip::where([
                ['day_id', $this->day_id],
                ['type', $this->type],
                ['trip_start', $value],
                ['id', '!=', $this->id]
            ])->count() == 0;
        }
    }


    public function message()
    {
        return 'This trip has already been created.';
    }
}
