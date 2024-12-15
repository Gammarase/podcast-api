<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'image_url' => $this->image_url,
            'language' => $this->language,
            'featured' => $this->featured,
            'admin_id' => $this->admin_id,
            'category_id' => $this->category_id,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'topics' => TopicCollection::make($this->whenLoaded('topics')),
            'episodes' => EpisodeCollection::make($this->whenLoaded('episodes')),
        ];
    }
}
