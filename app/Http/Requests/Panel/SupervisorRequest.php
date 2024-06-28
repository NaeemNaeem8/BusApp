<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class SupervisorRequest extends FormRequest
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

        if (Route::is('supervisors.store')) {
            $rule['name']       = ['required', ...$rule['name']];
            $rule['email']      = ['required', 'unique:supervisors,email', ...$rule['email']];
            $rule['password']   = ['required', ...$rule['password']];
            return $rule;
        } else {
            $id = request()->route('supervisor_id');
            $rule['name']       = ['nullable', ...$rule['name']];
            $rule['email']      = ['nullable', 'unique:supervisors,email,' . $id . ',id', ...$rule['email']];
            $rule['password']   = ['nullable', ...$rule['password']];
            return $rule;
        }
    }

    public function prepar_data_store()
    {
        return  [
            'name'              => $this->name,
            'email'             => $this->email,
            'password'          => $this->password,
            'image'             => $this->image != null ? $this->image->store('supervisorImage', 'public')
                : 'defualtImages/user.png',
        ];
    }
}
