<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class DriverRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $rule = [
            'name'              => ['string'],
            'email'             => ['email'],
            'password'          => ['string', 'min:8', 'max:20'],
            'image'             => ['image'],
        ];

        if (!Route::is('driver_update')) {
            $rule['name']       = ['required', ...$rule['name']];
            $rule['email']      = ['required', 'unique:drivers,email', ...$rule['email']];
            $rule['password']   = ['required', ...$rule['password']];
        } else if(Route::is('driver_update')) {
            $id = request()->route('driver_id');
            $rule['name']       = ['nullable', ...$rule['name']];
            $rule['email']      = ['nullable', 'unique:drivers,email,' . $id . ',id', ...$rule['email']];
            $rule['password']   = ['nullable', ...$rule['password']];
        }
        return $rule;
    }
}
