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
    public function definition(Array $ratingBetween = [0, 5], String $book_created_at = '-6 months' ): array
    {
        return [
           'review' => fake()->paragraph,
           'rating' => fake()->numberBetween($ratingBetween[0], $ratingBetween[1]),
           'created_at' => fake()->dateTimeBetween($book_created_at),
        ];
    }
}
