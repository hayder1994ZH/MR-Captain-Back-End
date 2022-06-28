<?php

namespace App\Http\Requests\DayMuscle;

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
            'muscle_id' => 'integer|exists:muscles,id',
            'course_day_id' => 'required|integer|exists:course_days,id',
        ];
    }
}
