<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type'          => ['required', Rule::in(['users', 'admins', 'supervisors','drivers'])],
            'email'         => ['required', 'email', 'exists:' . $this->type . ',email'],
            'password'      => ['required', 'string'],
        ];
    }
}
