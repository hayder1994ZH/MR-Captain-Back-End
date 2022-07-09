<?php

namespace App\Http\Requests\SubscriptionsGym;

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
        if(!Utilities::owner()){
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
            'is_active' => 'boolean|in:0,1',
            'is_sms' => 'boolean|in:0,1',
            'is_whatsapp' => 'boolean|in:0,1',
            'gym_id' => 'required|string|exists:gyms,uuid',
            'card_id' => 'required|integer|exists:cards,id',
        ];
    }
}
