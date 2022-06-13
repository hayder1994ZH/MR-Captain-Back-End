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
            'password' => 'required|string',
            'rule_id' => 'required|integer|exists:rules,id',
            'city_id' => 'required|integer|exists:cities,id',
            'gym_id' => 'required|string|exists:gyms,uuid',
        ];
    }
}
