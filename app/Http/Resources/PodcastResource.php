<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Facades\Storage;

class PodcastResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $this->image_url ? Storage::disk('public')->url($this->image_url) : null,
            'language' => $this->language,
            'featured' => $this->featured,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'topics' => TopicResource::collection($this->whenLoaded('topics')),
            'episodes' => EpisodeResource::collection($this->whenLoaded('episodes')),
            'author' => AuthorResource::make($this->whenLoaded('admin')),
            'is_saved' => $this->is_saved ?? new MissingValue,
        ];
    }
}
