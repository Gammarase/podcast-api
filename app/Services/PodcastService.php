<?php

namespace App\Services;

use App\Models\Podcast;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PodcastService extends AbstractService
{
    public function getFeatured(?int $seed = null): LengthAwarePaginator
    {
        $seed = $seed ?? now()->hour;

        return Podcast::where('featured', true)->orderByRaw("RAND($seed)")->paginate(20);
    }

    public function getPopular(): LengthAwarePaginator
    {
        return Podcast::withCount('savedByUsers')
            ->orderBy('saved_by_users_count', 'desc')
            ->paginate(20);
    }

    public function getDetailed(Podcast $podcast): Podcast
    {
        return $podcast->load('episodes', 'topics', 'category', 'admin');
    }

    public function addToSaved(User $user, Podcast $podcast): void
    {
        $user->savedPodcasts()->attach($podcast);
    }
}
