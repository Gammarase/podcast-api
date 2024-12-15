<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EpisodeGetNextEpisodesRequest extends FormRequest
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
            'duration' => ['required', 'integer', 'gt:0'],
            'episode_number' => ['required', 'integer'],
            'file_path' => ['required', 'string'],
            'podcast_id' => ['required', 'integer', 'exists:podcasts,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }
}
