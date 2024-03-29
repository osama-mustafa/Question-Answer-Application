<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;



class StoreProfileRequest extends FormRequest
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
                'required', 'string', 'alpha_dash', 'max:255',
                Rule::unique('users')->ignore(Auth::user()),
            ],

            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore(Auth::user()),
            ],
            'work' => ['string', 'nullable'],
            'facebook' => ['string', 'nullable'],
            'linkedin' => ['string', 'nullable'],
            'image' => ['nullable']
        ];
    }
}
