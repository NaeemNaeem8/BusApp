<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class BusRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'plate'                 =>  ['string'],
            'number_of_passengers'  =>  ['integer']
        ];

        if ($this->getMethod()   == 'POST') {
            $rules['plate']                 = ['required', 'unique:buses,plate', ...$rules['plate']];
            $rules['number_of_passengers']  = ['required', ...$rules['number_of_passengers']];
        } else {
            request()->merge(['bus_id' => request()->route('bus_id')]);
            $rules['bus_id']                = ['required', 'exists:buses,id'];
            $rules['plate']                 = ['nullable', 'unique:buses,plate,' . request()->route('bus_id') . ',id', ...$rules['plate']];
            $rules['number_of_passengers']  = ['required', ...$rules['number_of_passengers']];
        }
        return $rules;
    }
}
