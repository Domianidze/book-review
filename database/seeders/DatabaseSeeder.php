<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\Review;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private const RATING_BETWEENS = [
        [1, 2],
        [2, 4],
        [4, 5],
    ];


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Book::factory(50)->create()->each(function (Book $book) {
            $reviewCount = random_int(0, 50);
            $ratingBetween = self::RATING_BETWEENS[array_rand(self::RATING_BETWEENS)];

            Review::factory($reviewCount)->ratingBetween($ratingBetween)->bookCreatedAt($book->created_at)->for($book)->create();
        });

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
