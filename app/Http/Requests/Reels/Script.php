<?php

namespace App\Http\Requests\Reels;

use Illuminate\Foundation\Http\FormRequest;

class Script extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'description' => 'string',
            'videoUrl' => 'required|string',
            'image' => 'required|string',
            'size' => 'required|integer',
            'title' => 'required|string'
        ];
    }
}
