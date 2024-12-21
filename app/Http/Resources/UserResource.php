<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'email' => $this->email,
            'username' => $this->username,
            'image_url' => $this->image_url ? Storage::disk('public')->url($this->image_url) : null,
            'premium' => $this->havePremium,
            'liked_episodes' => EpisodeResource::collection($this->whenLoaded('likedEpisodes')),
            'saved_podcasts' => PodcastResource::collection($this->whenLoaded('savedPodcasts')),
        ];
    }
}
