<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
        $id = $this->route('user');
        return [
            'name' => 'string',
            'phone' => 'string|min:11|max:11|unique:users,phone'. $id,
            'logo' => 'string',
            'birth_date' => 'string',
            'country' => 'string',
            'city' => 'string',
            'gender' => 'string',
            'password' => 'string|min:6',
            'rule_id' => 'integer|exists:rules,id',
            'gym_id' => 'integer|exists:gyms,id',
        ];
    }
}
