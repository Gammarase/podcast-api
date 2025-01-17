<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->safeEmail(),
            'username' => $this->faker->userName(),
            'password' => $this->faker->password(),
            'image_url' => $this->faker->word(),
            'premium_until' => $this->faker->dateTime(),
        ];
    }
}
