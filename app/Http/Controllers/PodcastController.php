<?php

namespace App\Http\Controllers;

use App\Http\Requests\PodcastAddToSavedRequest;
use App\Http\Resources\PodcastCollection;
use App\Http\Resources\PodcastResource;
use App\Models\Podcast;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PodcastController extends Controller
{
    public function getFeatured(Request $request): PodcastCollection
    {
        $podcasts = Podcast::paginate();

        return new PodcastCollection($Podcasts);
    }

    public function getPopular(Request $request): PodcastCollection
    {
        $podcasts = Podcast::paginate();

        return new PodcastCollection($Podcasts);
    }

    public function getDetailed(Request $request): PodcastResource
    {
        return new PodcastResource($Podcast);
    }

    public function addToSaved(PodcastAddToSavedRequest $request): Response {}
}
