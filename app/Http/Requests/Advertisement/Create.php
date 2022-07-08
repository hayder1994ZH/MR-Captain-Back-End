<?php

namespace App\Http\Requests\Advertisement;

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
            'name' => 'required|string|max:255',
            'subtitle' => 'string',
            'url' => 'string|max:255',
            'phone' => 'string|max:255',
            'type' => 'required|string|max:255',
            'is_active' => 'required|boolean|in:0,1',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'city_id' => 'integer|exists:cities,id',
            'country_id' => 'integer|exists:countries,id',
            'gender' => 'required|string|in:male,female,both',
        ];
    }
}
