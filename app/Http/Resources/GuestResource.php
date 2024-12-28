<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GuestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            ...$this->only(['id', 'name', 'job_title']),
            'image_url' => $this->image_url ? Storage::disk('public')->url($this->image_url) : null,
        ];
    }
}
