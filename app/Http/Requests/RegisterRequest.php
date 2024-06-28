<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'           => ['required', 'string'],
            'email'          => ['required', 'email', 'unique:users,email'],
            'password'       => ['required', 'min:8', 'string'],
            'image'          => ['image'],
            'phone'          => ['required', 'string', 'min:10', 'max:10', 'unique:users,phone'],
            'register_type'  => ['required', Rule::in(['daily', 'session'])],
            'university_id'  => ['required', 'exists:universities,id'],
            'card_image'     => ['image', 'required_if:register_type,session'],
        ];
    }

    public function get_data()
    {
        return [
            'name'              => $this->name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'password'          => $this->password,
            'image'             => $this->image != null ? $this->image->store('usersImage', 'public')
                : asset('defualtImages/user.png'),
            'card_image'        => $this->card_image != null ? $this->card_image->store('usersCardImage', 'public') : null,
            'register_type'     => $this->register_type,
            'university_id'     => $this->university_id
        ];
    }
}
