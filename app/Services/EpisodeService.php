<?php

namespace App\Services;

use App\Models\Episode;
use App\Models\User;

class EpisodeService extends AbstractService
{
    public function getDetailed(Episode $episode)
    {
        return $episode->load([
            'guests',
            'category',
            'topics',
            'podcast.admin',
            'podcast.episodes' => function ($query) use ($episode) {
                $query->where('episode_number', '>', $episode->episode_number)->orderBy('episode_number')->limit(5);
            },
        ])
            ->loadExists(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->user()?->id);
            }])
            ->loadCount('likes');
    }

    public function like(Episode $episode, User $user)
    {
        $user->likedEpisodes()->toggle($episode->id);
    }
}
