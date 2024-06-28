<?php

namespace App\Http\Requests\Mobile;

use App\Rules\BookingRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BookingRequest extends FormRequest
{
    private $today;
    public $warnings;

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $this->today = now()->format('Y-m-d');

        return [
            'line_parking_id'   =>  [
                'required', 'exists:line_parkings,id',
                Rule::unique('bookings')->where(
                    fn ($q) => $q->where('user_id', auth()->id())
                        ->where('line_parking_id', $this->line_parking_id)
                        ->where('created_at', $this->today)
                )
            ]
        ];
    }

    public function passedValidation()
    {
        $line = DB::table('line_parkings')
            ->where('line_parkings.id', $this->line_parking_id)->first();

        $reservations_count = DB::table('line_parkings')
            ->where('line_parkings.line_trip_id', $line->line_trip_id)
            ->join('bookings as bk', 'bk.line_parking_id', '=', 'line_parkings.id')
            ->where('bk.created_at', $this->today)
            ->count();

        $bus = DB::table('line_parkings')
            ->where('line_parkings.line_trip_id', $line->line_trip_id)
            ->join('trip_buses as tb', 'line_parkings.id', '=', 'tb.line_parking_id')
            ->join('buses as b', 'b.id', '=', 'tb.bus_id')
            ->sum('b.number_of_passengers');

        $bus > $reservations_count ? $this->warnings = false : $this->warnings = true;
    }
}
