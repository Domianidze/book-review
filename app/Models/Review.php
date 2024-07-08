<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected static function booted()
    {
        $clearCache = function (Review $review) {
            cache()->forget('/books' . '/' . $review->book_id);
        };

        static::created($clearCache);
        static::updated($clearCache);
        static::deleted($clearCache);
    }

    protected $fillable = [
        'review',
        'rating'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
