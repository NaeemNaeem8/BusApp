<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SerachTripRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'day_id'        => ['nullable', 'exists:days,id'],
            'trip_start'    => ['nullable','date_format:H:i'],
            'type'          => ['nullable', Rule::in(['go', 'back'])],
        ];
    }
}
