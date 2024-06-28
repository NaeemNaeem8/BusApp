<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class LineParkingRule implements Rule
{

    public function __construct(public string $line_trip_id,public array $ids)
    {
        //
    }


    public function passes($attribute, $value)
    {
        return DB::table('line_parkings')->where('line_trip_id', $this->line_trip_id)
            ->whereIn('parking_id', $this->ids)->count() == 0;
    }


    public function message()
    {
        return 'The validation error message line_parkings.';
    }
}
