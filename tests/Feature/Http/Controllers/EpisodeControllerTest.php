<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Podcast;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EpisodeController
 */
final class EpisodeControllerTest extends TestCase
{
    use AdditionalAssertions, WithFaker;

    #[Test]
    public function getEpisodesOfPodcast_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EpisodeController::class,
            'getEpisodesOfPodcast',
            \App\Http\Requests\EpisodeGetEpisodesOfPodcastRequest::class
        );
    }

    #[Test]
    public function getEpisodesOfPodcast_behaves_as_expected(): void
    {
        $podcast = Podcast::factory()->create();

        $response = $this->get(route('episodes.getEpisodesOfPodcast'), [
            'podcast_id' => $podcast->id,
        ]);

        $response->assertOk();
        $response->assertJsonStructure([]);
    }

    #[Test]
    public function getNextEpisodes_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EpisodeController::class,
            'getNextEpisodes',
            \App\Http\Requests\EpisodeGetNextEpisodesRequest::class
        );
    }

    #[Test]
    public function getNextEpisodes_behaves_as_expected(): void
    {
        $title = $this->faker->sentence(4);
        $description = $this->faker->text();
        $duration = $this->faker->randomNumber();
        $episode_number = $this->faker->numberBetween(-10000, 10000);
        $file_path = $this->faker->word();
        $podcast = Podcast::factory()->create();
        $category = Category::factory()->create();

        $response = $this->get(route('episodes.getNextEpisodes'), [
            'title' => $title,
            'description' => $description,
            'duration' => $duration,
            'episode_number' => $episode_number,
            'file_path' => $file_path,
            'podcast_id' => $podcast->id,
            'category_id' => $category->id,
        ]);

        $response->assertOk();
        $response->assertJsonStructure([]);
    }

    #[Test]
    public function seachEpisodes_behaves_as_expected(): void
    {
        $response = $this->get(route('episodes.seachEpisodes'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }

    #[Test]
    public function getDetailed_behaves_as_expected(): void
    {
        $response = $this->get(route('episodes.getDetailed'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }

    #[Test]
    public function like_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EpisodeController::class,
            'like',
            \App\Http\Requests\EpisodeLikeRequest::class
        );
    }

    #[Test]
    public function like_behaves_as_expected(): void
    {
        $title = $this->faker->sentence(4);
        $description = $this->faker->text();
        $duration = $this->faker->randomNumber();
        $episode_number = $this->faker->numberBetween(-10000, 10000);
        $file_path = $this->faker->word();
        $podcast = Podcast::factory()->create();
        $category = Category::factory()->create();

        $response = $this->get(route('episodes.like'), [
            'title' => $title,
            'description' => $description,
            'duration' => $duration,
            'episode_number' => $episode_number,
            'file_path' => $file_path,
            'podcast_id' => $podcast->id,
            'category_id' => $category->id,
        ]);
    }
}
