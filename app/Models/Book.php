<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeSearch(Builder $query, string $value)
    {
        return $query->where('title', 'LIKE', '%' . $value . '%');
    }

    public function scopePopular(Builder $query)
    {
        return $query->withCount('reviews')->orderByDesc('reviews_count');
    }

    public function scopeHighestRated(Builder $query, int $minReviews = null)
    {
        if ($minReviews) {
            $query->withCount('reviews')->having('reviews_count', '>=', $minReviews);
        }

        return $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating');
    }
}
