<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PodcastAddToSavedRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'image_url' => ['required', 'string'],
            'language' => ['required', 'in:ua,en,es,fr,de,it,zh,ja,ko'],
            'featured' => ['required'],
            'admin_id' => ['required', 'integer', 'exists:admins,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }
}
