@extends('layouts.app')

@section('content')
<h1 class="mb-10 text-2xl">Books</h1>

<form method="get" action="{{ route('books.index') }}" class="mb-4 flex items-center space-x-2">
  <input type="text" name="search" placeholder="Search by title" value="{{ request('search') }}" class="input h-10">
  @foreach (request()->query() as $name => $value)
  <input type="hidden" name="{{ $name }}" value="{{ $value }}" />
  @endforeach
  <button class="btn h-10">Search</button>
  <a href="{{ route('books.index', request()->except('search')) }}" class="btn h-10">Clear</a>
</form>

<div class="filter-container mb-4 flex">
  @php
  $dateFormat = 'Y-m-d';

  $filters = [
  'Latest' => [
  'filter' => null,
  'fromDate' => null,
  ],
  'Popular Last Month' => [
  'filter' => 'popular',
  'fromDate' => now()->subMonth()->format($dateFormat),
  ],
  'Popular Last 6 Month' => [
  'filter' => 'popular',
  'fromDate' => now()->subMonths(6)->format($dateFormat),
  ],
  'Highest Rated Last Month' => [
  'filter' => 'highest_rated',
  'fromDate' => now()->subMonth()->format($dateFormat),
  ],
  'Highest Rated Last 6 Month' => [
  'filter' => 'highest_rated',
  'fromDate' => now()->subMonths(6)->format($dateFormat),
  ]
  ];
  @endphp

  @foreach ($filters as $label => $data)
  @php
  $href = route('books.index', [...request()->query(), ...$data]);
  $isActive = $data['filter'] === request('filter') && $data['fromDate'] === request('fromDate');
  @endphp

  <a href="{{ $href }}" class="{{ $isActive ? 'filter-item-active' : 'filter-item' }}">
    {{ $label }}
  </a>
  @endforeach
</div>

<ul>
  @forelse ($books as $book)
  <li class="mb-4">
    <div class="book-item">
      <div class="flex flex-wrap items-center justify-between">
        <div class="w-full flex-grow sm:w-auto">
          <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title }}</a>
          <span class="book-author">by {{ $book->author }}</span>
        </div>
        <div>
          <div class="book-rating">
            {{ number_format($book->reviews_avg_rating, 1) }}
          </div>
          <div class="book-review-count">
            out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
          </div>
        </div>
      </div>
    </div>
  </li>
  @empty
  <li class="mb-4">
    <div class="empty-book-item">
      <p class="empty-text">No books found</p>
      <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
    </div>
  </li>
  @endforelse
</ul>

<nav class="mt-4">
  {{ $books->links() }}
</nav>
@endsection