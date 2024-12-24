<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Facades\Storage;

class EpisodeResource extends JsonResource
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
            'duration' => $this->duration,
            'episode_number' => $this->episode_number,
            'file_path' => $this->file_path ? Storage::disk('public')->url($this->file_path) : null,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'topics' => TopicResource::collection($this->whenLoaded('topics')),
            'guests' => GuestResource::collection($this->whenLoaded('guests')),
            'podcast' => PodcastResource::make($this->whenLoaded('podcast')),
            'next_episodes' => $this->when(
                $this->relationLoaded('podcast') && $this->podcast->relationLoaded('episodes'),
                fn () => EpisodeResource::collection($this->podcast->episodes)
            ),
            'is_liked' => $this->is_liked ?? new MissingValue,
            'likes_count' => $this->likes_count ?? new MissingValue,
        ];
    }
}
