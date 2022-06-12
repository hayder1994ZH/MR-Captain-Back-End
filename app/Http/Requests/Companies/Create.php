<?php

namespace App\Http\Requests\Companies;

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
            'title' => 'required|string',
            'url' => 'required|string',
            'httpport' => 'required|string',
            'streamurl' => 'required|string',
            'streamport' => 'required|string',
            'localip' => 'required|string',
            'is_ssl' => 'required|integer|in:0,1',
            'is_defualt' => 'required|integer|in:0,1',
        ];
    }
}
