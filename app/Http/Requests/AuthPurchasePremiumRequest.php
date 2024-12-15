<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthPurchasePremiumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'cvv' => ['required', 'min:3', 'max:4', 'integer'],
            'card_number' => ['required', 'integer', 'min:16', 'max:16'],
            'expiration_date' => ['required', 'date_format:m/y'],
            'card_holder' => ['required', 'string'],
        ];
    }
}
