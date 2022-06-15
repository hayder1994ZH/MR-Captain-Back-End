<?php

namespace App\Http\Requests\Subscription;

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
            'is_active' => 'boolean|in:0,1',
            'is_sms' => 'boolean|in:0,1',
            'is_whatsapp' => 'boolean|in:0,1',
            'player_id' => 'required|integer|exists:users,id',
            'card_id' => 'required|integer|exists:cards,id',
        ];
    }
}
