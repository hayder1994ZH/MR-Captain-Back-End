<?php

namespace App\Http\Requests\Companies;

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
            'title' => 'string',
            'url' => 'string',
            'httpport' => 'string',
            'streamurl' => 'string',
            'streamport' => 'string',
            'localip' => 'string',
            'is_ssl' => 'integer|in:0,1',
            'is_defualt' => 'integer|in:0,1',
        ];
    }
}
