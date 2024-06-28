<?php

namespace App\Http\Requests\Mobile;

use App\Services\GeneralServices;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserDaysRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    private $days;
    public function prepareForValidation()
    {
        if ($this->getMethod()   == 'POST') {
            $ser = new GeneralServices();
            try {
                $this->days = $ser->convert_to_array($this->user_days, 'day_id');
            } catch (\Throwable $th) {
                abort(404, 'missing some arguments');
            }
            if ($ser->check_duplicates($this->days)) abort(404, 'You can\'t duplicate days');
        } else {
            request()->merge(['user_day_id' => request()->route('user_day_id')]);
        }
    }

    public function rules()
    {
        $id = auth()->id();
        if ($this->getMethod() == 'POST') {
            return [
                'user_days'             => ['required', 'array', Rule::unique('user_days', 'day_id')->where(fn ($q)
                => $q->whereIn('day_id', $this->days)->where('user_id', $id))],
                'user_days.*.day_id'    => ['required', 'exists:days,id,deleted_at,NULL'],
                'user_days.*.go'        => ['required', 'date_format:H:i'],
                'user_days.*.back'      => ['required', 'date_format:H:i', 'after:user_days.*.go'],
            ];
        } else {
            return [
                'day_id'        => ['nullable', Rule::unique('user_days')->where(fn ($q) =>
                $q->where('day_id', $this->day_id)->where('user_id', $id))],
                'go'            => ['nullable', 'date_format:H:i'],
                'back'          => ['nullable', 'date_format:H:i', 'after:go'],
            ];
        }
    }
}
