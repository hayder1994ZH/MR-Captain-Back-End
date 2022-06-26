<?php

namespace App\Http\Requests\HandPay;

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
            'details' => 'string|max:255',
            'price' => 'required|numeric',
            'player_id' => 'required|exists:users,id',
            'debt_id' => 'required|exists:debts,id',
        ];
    }
}
