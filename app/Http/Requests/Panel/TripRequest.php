<?php

namespace App\Http\Requests\Panel;

use App\Rules\TripExistRule;
use App\Services\GeneralServices;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TripRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }
    public function prepareForValidation()
    {
        if ($this->getMethod()   == 'POST') {
            $service = new GeneralServices();
            try {
                $line_ids    = $service->convert_to_array($this->lines_id, 'line_id');
            } catch (\Throwable $th) {
                abort(404, 'missing arguments');
            }
            if ($service->check_duplicates($line_ids))
                abort(404, 'You mustn\'t duplicate lines for same trip');
        }
    }

    public function rules()
    {
        $rule = [
            'type'                                  => [Rule::in(['go', 'back'])],
            'trip_start'                            => ['date_format:H:i'],
            'day_id'                                => ['exists:days,id'],
            'details'                               => ['nullable', 'string'],
            'lines_id'                              => ['array', 'required', 'unique:line_trips,trip_id'],
            'lines_id.*.line_id'                    => ['exists:lines,id'],
        ];

        if ($this->getMethod()   == 'POST') {
            $rule['type']           = ['required', ...$rule['type']];
            $rule['trip_start']     = [
                'required', new TripExistRule($this->type, $this->day_id),
                ...$rule['trip_start']
            ];
        } else {
            $rule['type']        = ['required', ...$rule['type']];
            $rule['trip_start']  = [
                'required',
                new TripExistRule($this->type, $this->day_id, 'update', request()->route('trip_id')),
                ...$rule['trip_start']
            ];
            unset($rule['lines_id'], $rule['lines_id.*.line_id']);
        }
        return $rule;
    }
}
