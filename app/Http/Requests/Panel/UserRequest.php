<?php

namespace App\Http\Requests\Panel;

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
        $user_id  = request()->route('user_id');
        $rule = [
            'name'                  => ['nullable', 'string'],
            'email'                 => ['nullable', 'email', 'unique:users,email,' . $user_id . ',id'],
            'image'                 => ['nullable', 'image'],
            'phone'                 => ['nullable', 'string', 'unique:users,phone,' . $user_id . ',id'],
            'confirmed'             => ['nullable', 'boolean'],
            'register_type'         => ['nullable', Rule::in(['daily', 'session'])],
            'card_image'            => ['nullable', 'image'],
            'password'              => ['nullable', 'string', 'min:8', 'max:20'],
            'university_id'         => ['nullable', 'exists:universiteis,id'],
        ];
    }
}
