<?php

namespace App\Http\Requests\Subscription;

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
            'is_active' => 'boolean|in:0,1',
            'is_sms' => 'boolean|in:0,1',
            'is_whatsapp' => 'boolean|in:0,1',
            'player_id' => 'integer|exists:users,id',
            'card_id' => 'integer|exists:cards,id',
        ];
    }
}
