<?php

namespace App\Models;

use App\Traits\ClearsCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    use ClearsCache;

    protected $fillable = [
        'review',
        'rating'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
