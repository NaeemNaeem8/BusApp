<?php

namespace App\Http\Requests\Mobile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $user_id = auth()->id();
        return [
            'name'           => ['nullable', 'string'],
            'email'          => ['nullable', 'email', 'unique:users,email,' . $user_id . ',id'],
            'phone'          => ['nullable', 'string', 'min:10', 'max:10', 'unique:users,phone,' . $user_id . ',id'],
            'password'       => ['nullable', 'min:8', 'string'],
            'image'          => ['image'],
            'university_id'  => ['nullable', 'exists:universities,id'],
        ];
    }
}
