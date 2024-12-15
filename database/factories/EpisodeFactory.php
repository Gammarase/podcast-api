<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Episode;
use App\Models\Podcast;
use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeFactory extends Factory
{
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
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->text(),
            'duration' => $this->faker->numberBetween(1, 120),
            'episode_number' => $this->faker->numberBetween(1, 100),
            'file_path' => $this->faker->word(),
            'podcast_id' => Podcast::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
