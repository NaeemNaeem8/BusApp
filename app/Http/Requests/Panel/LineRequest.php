<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class LineRequest extends FormRequest
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
        if (Route::is('lines.store')) {
            $rule['name'] = ['required', 'unique:lines,name', ...$rule['name']];
            return $rule;
        } else {
            $rule['name'] = [
                'nullable',
                'unique:lines,name,' . request()->route('line_id') . ',id', ...$rule['name']
            ];
            return $rule;
        }
    }
}
