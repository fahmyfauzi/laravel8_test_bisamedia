<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $userId = User::inRandomOrder()->first();

        return [
            'title' => $this->faker->text(50),
            'author' => $this->faker->name(),
            'price' => $this->faker->numberBetween(100, 500),
            'user_id' => $userId
        ];
    }
}
