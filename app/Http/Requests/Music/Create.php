<?php

namespace App\Http\Requests\Music;

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
            'image' => 'image|mimes:png,jpg,jpeg',
            'music' => 'file|mimes:mp3',
            'url' => 'string'
        ];
    }
}
