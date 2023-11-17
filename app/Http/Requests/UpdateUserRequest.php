<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule as ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class UpdateUserRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'alpha_dash',
                'max:50',
                Rule::unique('users')->ignore($this->user->id),
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:70',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'work' => ['nullable'],
            'facebook' => ['nullable'],
            'linkedin' => ['nullable'],
        ];
    }
}
