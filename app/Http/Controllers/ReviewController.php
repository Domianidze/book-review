<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        $data = $request->validate([
            'review' => 'min:10|max:500|required',
            'rating' => 'integer|min:1|max:5|required',
        ]);

        $executed = RateLimiter::attempt(
            'books.reviews.store:' . ($request->user()?->id ?: $request->ip()),
            5,
            function () use ($book, $data) {
                $book->reviews()->create($data);
            },
            3600,
        );

        return redirect()->route('books.show', $book)->with($executed ? 'success' : 'error', $executed ? 'Review has been added successfully!' : 'Hourly limit reached. Please try again later.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
