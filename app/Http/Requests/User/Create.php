<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
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
            'name' => 'required|string',
            'phone' => 'required|string|min:11|max:11|unique:users,phone',
            'logo' => 'string',
            'birth_date' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'gender' => 'required|string',
            'password' => 'required|string|min:6',
            'rule_id' => 'required|integer|exists:rules,id',
            'gym_id' => 'required|integer|exists:gyms,id',
        ];
    }
}
