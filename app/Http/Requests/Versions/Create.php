<?php

namespace App\Http\Requests\Versions;

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
            'version' => 'required|string|max:255',
            'android_url' => 'required|string|max:255',
            'android_public' => 'integer|in:0,1',
            'android_active' => 'integer|in:0,1',
            'android_cache' => 'integer|in:0,1',
            'ios_url' => 'required|string|max:255',
            'ios_public' => 'integer|in:0,1',
            'ios_active' => 'integer|in:0,1',
            'ios_cache' => 'integer|in:0,1',
        ];
    }
}
