<?php

namespace App\Http\Controllers;

use App\Http\Requests\EpisodeGetEpisodesOfPodcastRequest;
use App\Http\Requests\EpisodeGetNextEpisodesRequest;
use App\Http\Requests\EpisodeLikeRequest;
use App\Http\Resources\EpisodeCollection;
use App\Http\Resources\EpisodeResource;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EpisodeController extends Controller
{
    public function getEpisodesOfPodcast(EpisodeGetEpisodesOfPodcastRequest $request): EpisodeCollection
    {
        $episodes = Episode::paginate();

        return new EpisodeCollection($Episodes);
    }

    public function getNextEpisodes(EpisodeGetNextEpisodesRequest $request): EpisodeCollection
    {
        $episodes = Episode::paginate();

        return new EpisodeCollection($Episodes);
    }

    public function seachEpisodes(Request $request): EpisodeCollection
    {
        $episodes = Episode::paginate();

        return new EpisodeCollection($Episodes);
    }

    public function getDetailed(Request $request): EpisodeResource
    {
        return new EpisodeResource($Episode);
    }

    public function like(EpisodeLikeRequest $request): Response {}
}
