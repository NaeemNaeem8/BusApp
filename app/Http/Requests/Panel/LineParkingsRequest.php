<?php

namespace App\Http\Requests\Panel;

use App\Models\LineTrip;
use App\Services\GeneralServices;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LineParkingsRequest extends FormRequest
{
    public $trip_id, $tripTime;

    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $ser = new GeneralServices;
        $parking_ids = [];
        try {
            $lineTrip =  LineTrip::with('trip')->whereId($this->linesParkings[0]['line_trip_id'])->firstOrFail();

            $line_trip_ids  =    $ser->convert_to_array($this->linesParkings, 'line_trip_id');

            foreach ($this->linesParkings as $key => $lines) {
                foreach ($lines['parkings_ids'] as $key => $value) {
                    $parking_ids[] = $value['parking_id'];
                }
            }
        } catch (\Throwable $th) {
            abort(404, 'missing some arguments');
            // return response()->error($th->getMessage());
        }

        if ($ser->check_duplicates($line_trip_ids) || $ser->check_duplicates($parking_ids)) {
            abort(404, 'you mustn\'t duplicate lines or parkings in same trip');
        }
        $this->trip_id = $lineTrip->trip_id;
        $this->tripTime = $lineTrip->trip->trip_start->format('H:i');
    }

    public function rules()
    {
        if ($this->getMethod()   == 'POST') {
            $rules = [
                'linesParkings'                                     => ['array', 'required'],
                'linesParkings.*.line_trip_id'                      => [
                    'required',
                    Rule::exists('line_trips', 'id')->where(fn ($q) => $q->where('trip_id', $this->trip_id))
                ],
                'linesParkings.*.line_trip_id'                      => ['unique:line_parkings,line_trip_id'],
                'linesParkings.*.parkings_ids'                      => ['array', 'required'],
                'linesParkings.*.parkings_ids.*.parking_id'         => ['required', 'exists:parkings,id'],
                'linesParkings.*.parkings_ids.*.arrive_time'        => [
                    'required', 'date_format:H:i',
                    'after_or_equal:' . $this->tripTime
                ]
            ];
        }
        return $rules;
    }

    public function get_date()
    {
        $data = [];
        $date = now();
        foreach ($this->linesParkings as $keyLine => $lines) {
            foreach ($lines['parkings_ids'] as $key => $value) {
                $data[] = [
                    'id'            => GeneralServices::ulid('line_parkings'),
                    'arrive_time'   => $value['arrive_time'],
                    'line_trip_id'  => $lines['line_trip_id'],
                    'parking_id'    => $value['parking_id'],
                    'created_at'    => $date,
                    'updated_at'    => $date
                ];
            }
        }
        return $data;
    }
}
