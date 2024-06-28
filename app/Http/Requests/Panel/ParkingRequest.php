<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class ParkingRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $rule = [
            'name'  => ['string'],
        ];
        if ($this->getMethod() == 'POST') {
            $rule['name'] = ['required', 'unique:parkings,name', ...$rule['name']];
            return $rule;
        } else {
            $rule['name'] = [
                'nullable',
                'unique:parkings,name,' . request()->route('parking_id') . ',id', ...$rule['name']
            ];
            return $rule;
        }
    }
}
