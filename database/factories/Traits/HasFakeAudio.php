<?php

namespace Database\Factories\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasFakeAudio
{
    private function fetchAndStoreAudio(string $folderName = 'audio'): ?string
    {
        try {
            // Example API: FreeSound.org (Replace API_KEY with your own key)
            $response = Http::get('https://freesound.org/apiv2/search/text/', [
                'query' => 'podcast',
                'filter' => 'duration:[10 TO 60]', // Example filter for duration between 10s and 60s
                'fields' => 'id,name,previews',
                'token' => env('FREESOUND_API_KEY'),
            ]);

            if ($response->successful()) {
                $results = $response->json()['results'] ?? [];
                if (empty($results)) {
                    throw new \Exception('No audio results found.');
                }

                $randomAudio = $results[array_rand($results)];
                $audioUrl = $randomAudio['previews']['preview-hq-mp3'] ?? null;

                if ($audioUrl) {
                    $audioContent = Http::get($audioUrl)->body();
                    $fileName = $folderName.DIRECTORY_SEPARATOR.Str::uuid().'.mp3';

                    Storage::disk('public')->put($fileName, $audioContent);

                    return $fileName;
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch audio: '.$e->getMessage());
        }

        return null;
    }
}
