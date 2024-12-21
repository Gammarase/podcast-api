<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Podcast;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PodcastFactory extends Factory
{
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
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->text(),
            'image_url' => Str::after($this->faker->image(storage_path('app/public/podcasts')), 'app/public/'),
            'language' => $this->faker->randomElement(['ua', 'en', 'es', 'fr', 'de', 'it', 'zh', 'ja', 'ko']),
            'featured' => $this->faker->boolean(),
            'admin_id' => Admin::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
