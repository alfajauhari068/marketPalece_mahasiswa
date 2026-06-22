<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'bio' => $this->faker->sentence(),
            // store skills as array to match Profile casts
            'skills' => [$this->faker->word(), $this->faker->word()],
            'photo' => $this->faker->imageUrl(200, 200),
            'rating_avg' => $this->faker->randomFloat(2, 1, 5),
        ];
    }
}
