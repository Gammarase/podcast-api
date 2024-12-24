<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Episode;
use App\Models\Podcast;
use Database\Factories\Traits\HasFakeAudio;
use Database\Factories\Traits\HasFakeImages;
use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeFactory extends Factory
{
    use HasFakeAudio, HasFakeImages;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Episode::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->getRandomPodcastPhrase(),
            'description' => $this->faker->text(),
            'image_url' => $this->storeRandomColorImage(),
            'duration' => $this->faker->numberBetween(1, 120),
            'episode_number' => $this->faker->numberBetween(1, 100),
            'file_path' => $this->fetchAndStoreAudio(),
            'podcast_id' => Podcast::inRandomOrder()->first() ?? Podcast::factory(),
            'category_id' => Category::inRandomOrder()->first() ?? Category::factory(),
        ];
    }
}
