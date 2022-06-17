<?php

namespace App\Http\Requests\Advertisement;

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
        return [
            'name' => 'string|max:255',
            'subtitle' => 'string|max:255',
            'url' => 'string|max:255',
            'phone' => 'string|max:255',
            'type' => 'string|max:255',
            'is_active' => 'boolean|in:0,1',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'city_id' => 'integer|exists:cities,id',
            'country_id' => 'integer|exists:countries,id',
            'gender' => 'string|in:male,female,both',
        ];
    }
}
