<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BookingRule implements Rule
{

    public function __construct()
    {
        //
    }


    public function passes($attribute, $value)
    {
        $today = now()->format('Y-m-d');
        
        $reservations_count = DB::table('bookings')->where($attribute, $value)
            ->where('created_at', $today)->count();

        $bus = DB::table('line_parkings')
            ->where('line_parkings.id', $value)
            ->join('trip_buses as tb', 'line_parkings.id', '=', 'tb.line_parking_id')
            ->join('buses as b', 'b.id', '=', 'tb.bus_id')
            ->sum('b.number_of_passengers');

        return  $reservations_count < $bus;
    }


    public function message()
    {
        return 'The validation error message. bookings';
    }
}
