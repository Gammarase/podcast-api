<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthUpdateUserRequest extends FormRequest
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
            'email' => 'nulable|email|unique:users',
            'username' => 'nulable|string|unique:users',
            'password' => 'nulable|string|min:8',
            'image' => 'nulable|image',
        ];
    }
}
