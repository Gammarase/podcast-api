<?php

namespace App\Http\Controllers;

use App\Http\Resources\Pagination;
use App\Http\Resources\PodcastResource;
use App\Http\Response as AppResponse;
use App\Models\Podcast;
use App\Services\PodcastService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PodcastController extends Controller
{
    public function __construct(private PodcastService $podcastService) {}

    public function getFeatured(Request $request)
    {
        return AppResponse::success(new Pagination(
            $this->podcastService->getFeatured(),
            PodcastResource::class
        ));
    }

    public function getPopular(Request $request)
    {
        return AppResponse::success(new Pagination(
            $this->podcastService->getPopular(),
            PodcastResource::class
        ));
    }

    public function getDetailed(Request $request, Podcast $podcast)
    {
        return AppResponse::success(
            PodcastResource::make($this->podcastService->getDetailed($podcast))
        );
    }

    public function addToSaved(Request $request, Podcast $podcast)
    {
        $this->podcastService->addToSaved($request->user(), $podcast);

        return AppResponse::success([], Response::HTTP_NO_CONTENT);
    }
}
