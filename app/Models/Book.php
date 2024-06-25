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

    public function scopeSearch(Builder $query, string $value = null)
    {
        if (!$value) return;

        return $query->where('title', 'LIKE', '%' . $value . '%');
    }

    public function scopePopular(Builder $query, string $fromDate = null)
    {
        return $query->withCount(['reviews' => self::dateFilter($fromDate)])->orderByDesc('reviews_count');
    }

    public function scopeHighestRated(Builder $query, int $minReviews = null, string $fromDate = null)
    {
        if ($minReviews) {
            $query->withCount(['reviews' => self::dateFilter($fromDate)])->having('reviews_count', '>=', $minReviews);
        }

        return $query->withAvg(['reviews' => self::dateFilter($fromDate)], 'rating')->orderByDesc('reviews_avg_rating');
    }

    private function dateFilter(string $fromDate = null)
    {
        return  function (Builder $query) use ($fromDate) {
            if (!$fromDate) return;

            return $query->where('created_at', '>=', $fromDate);
        };
    }
}
