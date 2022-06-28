<?php

namespace App\Http\Requests\MuscleTraining;

use App\Helpers\Utilities;
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
            'training_id' => 'required|integer|exists:trainings,id',
            'day_muscle_id' => 'required|integer|exists:day_muscles,id',
            'push_id' => 'required|integer|exists:pushes,id',
        ];
    }
}
