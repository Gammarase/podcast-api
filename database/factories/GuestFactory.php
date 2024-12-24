<?php

namespace Database\Factories;

use App\Models\Guest;
use Database\Factories\Traits\HasFakeImages;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuestFactory extends Factory
{
    use HasFakeImages;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Guest::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'job_title' => $this->faker->jobTitle(),
            'image_url' => $this->storeFakeImage(),
        ];
    }
}
