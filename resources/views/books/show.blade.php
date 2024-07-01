@extends('layouts.app')

@section('content')
<div class="mb-4">
  <h1 class="mb-2 text-2xl">{{ $book->title }}</h1>

  <div class="book-info">
    <div class="book-author mb-4 text-lg font-semibold">by {{ $book->author }}</div>
    <div class="book-rating flex items-center">
      <div class="mr-2 text-sm font-medium text-slate-700">
        <x-star-rating :rating="$book->reviews_avg_rating" />
      </div>
      <span class="book-review-count text-sm text-gray-500">
        {{ $book->reviews_count }} {{ Str::plural('review', 5) }}
      </span>
    </div>
  </div>
</div>

<div>
  <h2 class="mb-4 text-xl font-semibold">Reviews</h2>
  <form method="POST" action="{{ route('books.reviews.store', $book) }}" class="book-item mb-4">
    @csrf
    <div class="mb-2">
      <textarea name="review" placeholder="Review" rows="3" @class(['input', '!border-red-500'=> $errors->has('review')])>{{ old('review') }}</textarea>
      @error('review')
      <p class="text-red-500">{{ $message }}</p>
      @enderror
    </div>
    <select name="rating" class="input mb-2">
      @for ($i = 5; $i > 0; $i--)
      <option value="{{ $i }}" {{ $i == old('rating') ? 'selected' : '' }}>
        {{$i}} Stars
      </option>
      @endfor
    </select>
    <button type="submit" class="btn mt-2 h-10">Add Review</button>
  </form>
  <ul>
    @forelse ($reviews as $review)
    <li class="book-item mb-4">
      <div>
        <div class="mb-2 flex items-center justify-between">
          <div class="font-semibold">
            <x-star-rating :rating="$review->rating" />
          </div>
          <div class="book-review-count">
            {{ $review->created_at->format('M j, Y') }}
          </div>
        </div>
        <p class="text-gray-700">{{ $review->review }}</p>
      </div>
    </li>
    @empty
    <li class="mb-4">
      <div class="empty-book-item">
        <p class="empty-text text-lg font-semibold">No reviews yet</p>
      </div>
    </li>
    @endforelse
  </ul>

  <nav class="mt-4">
    {{ $reviews->links() }}
  </nav>
</div>
@endsection