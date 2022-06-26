<?php

namespace App\Http\Requests\Course;

use App\Helpers\Utilities;
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
        if(!Utilities::admin() && !Utilities::captain()){
            return false;
        }
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
            'details' => 'nullable|string',
            'weight' => 'nullable|string',
            'price' => 'nullable|string',
            'player_id' => 'integer|exists:users,id',
        ];
    }
}
