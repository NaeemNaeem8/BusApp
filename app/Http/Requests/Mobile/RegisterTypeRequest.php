<?php

namespace App\Http\Requests\Mobile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterTypeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'register_type'         => ['required', Rule::in(['daily', 'session'])],
            'card_image'            => ['nullable','image','required_if:register_type,session'],
        ];
    }

    public function getData(){
        return [
            'new_register_type' => $this->register_type,
            'card_image'        => $this->card_image,
            'user_id'           => auth()->id()
        ];
    }
}
