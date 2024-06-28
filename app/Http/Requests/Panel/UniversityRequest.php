<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class UniversityRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $rule =  [
            'name'          => ['string'],
            'logo'          => ['nullable','image'],
        ];
        if (Route::is('universities.store')) {
            $rule['name'] = [...$rule['name'], 'unique:universities,name'];
            // $rule['logo'] = [...$rule['logo']];
            return  $rule;
        } else {
            $rule['name'] = [
                'unique:universities,name,' . request()->route('university_id') . ',id', 'required',
                ...$rule['name']
            ];
            // $rule['logo'] = ['nullable', ...$rule['logo']];
            return  $rule;
        }
    }
}
