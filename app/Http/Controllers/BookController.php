<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter');
        $fromDate = $request->input('fromDate');

        $books = Book::search($search);

        match ($filter) {
            'popular' => $books->popular($fromDate)->highestRated(null, $fromDate),
            'highest_rated' => $books->highestRated(10, $fromDate)->orderByDesc('reviews_count'),
            default => $books->withAvg('reviews', 'rating')->withCount('reviews')->latest(),
        };

        $queryString = $request->getQueryString();
        $cacheKey = '/books' . ($queryString ? '?' . $queryString : '');
        $books = cache()->remember($cacheKey, env('CACHE_DURATION'), fn () => $books->paginate(10)->withQueryString());

        return view('books.index', compact('books'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        function getData(Book $book)
        {
            $book = $book->loadAvg('reviews', 'rating')->loadCount('reviews');
            $reviews = $book->reviews()->latest()->paginate(10);

            return compact('book', 'reviews');
        };

        $cacheKey = '/books' . '/' . $book->id;
        $data = cache()->remember($cacheKey, env('CACHE_DURATION'), fn () => getData($book));

        return view('books.show', $data);
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
