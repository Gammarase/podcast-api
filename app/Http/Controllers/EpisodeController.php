<?php

namespace App\Http\Controllers;

use App\Http\Resources\EpisodeResource;
use App\Http\Resources\Pagination;
use App\Http\Response as AppResponse;
use App\Models\Episode;
use App\Services\EpisodeService;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    public function __construct(private EpisodeService $episodeService) {}

    /**
     * @queryParam page int The page number. Example: 4
     * @queryParam filter[search] string Optional Search by a keyword in the title. Example: "exciting"
     * @queryParam filter[category] int Optional Filter by category ID. Example: 2
     * @queryParam filter[topics] string Optional Filter by one or more topic IDs (comma-separated). Example: "1,3,5"
     * @queryParam filter[guests] string Optional Filter by one or more guest IDs (comma-separated). Example: "4,7"
     * @queryParam filter[language] string Optional Filter by language. Enum: ua,en,es,fr,de,it,zh,ja,ko Example: "en"
     * @queryParam sort string Optional Sort by a specific field. Allowed values: "popularity", "-popularity", "duration", "-duration", "uploaded_at", "-uploaded_at". Example: "-popularity"
     */
    public function seachEpisodes(Request $request)
    {
        return AppResponse::success(new Pagination(
            $this->episodeService->search(),
            EpisodeResource::class
        ));
    }

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
