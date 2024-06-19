<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'review' => fake()->paragraph,
            'rating' => fake()->numberBetween(0, 5),
            'created_at' => fake()->dateTimeBetween('-6 months'),
        ];
    }
    public function ratingBetween(array $value)
    {
        return $this->state(
            [
                'rating' => fake()->numberBetween($value[0], $value[1]),
            ]
        );
    }

    public function bookCreatedAt(String $value)
    {
        return $this->state([
            'created_at' => fake()->dateTimeBetween($value),
        ]);
    }
}
