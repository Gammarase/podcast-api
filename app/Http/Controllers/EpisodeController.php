<?php

namespace App\Http\Controllers;

use App\Http\Resources\EpisodeCollection;
use App\Http\Resources\EpisodeResource;
use App\Http\Response as AppResponse;
use App\Models\Episode;
use App\Services\EpisodeService;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    public function __construct(private EpisodeService $episodeService) {}

    public function seachEpisodes(Request $request): EpisodeCollection {}

    public function getDetailed(Request $request, Episode $episode)
    {
        return AppResponse::success(new EpisodeResource(
            $this->episodeService->getDetailed($episode)
        ));
    }

    public function like(Request $request, Episode $episode)
    {
        $this->episodeService->like($episode, $request->user());

        return AppResponse::success([], AppResponse::HTTP_NO_CONTENT);
    }
}
