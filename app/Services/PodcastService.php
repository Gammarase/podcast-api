<?php

namespace App\Services;

use App\Models\Podcast;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PodcastService extends AbstractService
{
    public function getFeatured(?int $seed = null): LengthAwarePaginator
    {
        $user = auth()->user();
        $seed = $seed ?? now()->hour;

        return Podcast::where('featured', true)
            ->with('admin')
            ->withExists(['savedByUsers as is_saved' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->orderByRaw("RAND($seed)")
            ->paginate(20);
    }

    public function getPopular(): LengthAwarePaginator
    {
        $user = auth()->user();

        return Podcast::withCount('savedByUsers')
            ->with('admin')
            ->withExists(['savedByUsers as is_saved' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->orderBy('saved_by_users_count', 'desc')
            ->paginate(20);
    }

    public function getNew(): LengthAwarePaginator
    {
        $user = auth()->user();

        return Podcast::with('admin')
            ->withExists(['savedByUsers as is_saved' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    public function getDetailed(Podcast $podcast): Podcast
    {
        $user = auth()->user();

        return $podcast->load([
            'episodes' => function ($query) {
                $query->orderBy('episode_number');
            },
            'topics',
            'category',
            'admin',
        ])
            ->loadExists(['savedByUsers as is_saved' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }]);
    }

    public function addToSaved(User $user, Podcast $podcast): void
    {
        $user->savedPodcasts()->toggle($podcast);
    }
}
