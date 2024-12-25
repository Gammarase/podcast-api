<?php

namespace App\Services;

use App\Models\Episode;
use App\Models\User;
use App\Sorts\RelationCountSort;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

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

    public function search()
    {
        return QueryBuilder::for(Episode::class)
            ->allowedFilters([
                AllowedFilter::partial('search', 'title'),
                AllowedFilter::exact('category', 'category_id'),
                AllowedFilter::scope('topics', 'filter_has_topics'),
                AllowedFilter::scope('guests', 'filter_has_guests'),
                AllowedFilter::scope('language'),
            ])
            ->allowedSorts([
                AllowedSort::custom('popularity', new RelationCountSort, 'likes'),
                AllowedSort::field('duration'),
                AllowedSort::field('uploaded_at', 'created_at'),
            ])
            ->paginate(20);
    }
}
