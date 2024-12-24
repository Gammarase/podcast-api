<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Podcast;
use Database\Factories\Traits\HasFakeImages;
use Illuminate\Database\Eloquent\Factories\Factory;

class PodcastFactory extends Factory
{
    use HasFakeImages;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Podcast::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->getRandomPodcastPhrase(),
            'description' => $this->faker->text(),
            'image_url' => $this->storeRandomColorImage(),
            'language' => $this->faker->randomElement(['ua', 'en', 'es', 'fr', 'de', 'it', 'zh', 'ja', 'ko']),
            'featured' => $this->faker->boolean(),
            'admin_id' => Admin::inRandomOrder()->first() ?? Admin::factory(),
            'category_id' => Category::inRandomOrder()->first() ?? Category::factory(),
        ];
    }
}
