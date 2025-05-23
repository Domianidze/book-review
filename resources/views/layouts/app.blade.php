<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Book Reviews</title>
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
  <script>
    tailwind.config = {
      darkMode: 'false',
    }
  </script>

  {{-- blade-formatter-disable --}}
  <style type="text/tailwindcss">
    .btn {
      @apply bg-white rounded-md px-4 py-2 text-center font-medium text-slate-500 shadow-sm ring-1 ring-slate-700/10 hover:bg-slate-50 h-10;
    }

    .input {
      @apply shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none rounded-md border-slate-300;
    }

    .filter-container {
      @apply mb-4 flex space-x-2 rounded-md bg-slate-100 p-2;
    }

    .filter-item {
      @apply flex w-full items-center justify-center rounded-md px-4 py-2 text-center text-sm font-medium text-slate-500;
    }

    .filter-item-active {
      @apply bg-white shadow-sm text-slate-800 flex w-full items-center justify-center rounded-md px-4 py-2 text-center text-sm font-medium;
    }

    .book-item {
      @apply text-sm rounded-md bg-white p-4 leading-6 text-slate-900 shadow-md shadow-black/5 ring-1 ring-slate-700/10;
    }

    .book-title {
      @apply text-lg font-semibold text-slate-800 hover:text-slate-600;
    }

    .book-author {
      @apply block text-slate-600;
    }

    .book-rating {
      @apply text-sm font-medium text-slate-700;
    }

    .book-review-count {
      @apply text-xs text-slate-500;
    }

    .empty-book-item {
      @apply text-sm rounded-md bg-white py-10 px-4 text-center leading-6 text-slate-900 shadow-md shadow-black/5 ring-1 ring-slate-700/10;
    }

    .empty-text {
      @apply font-medium text-slate-500;
    }

    .reset-link {
      @apply text-slate-500 underline;
    }
  </style>
  {{-- blade-formatter-enable --}}
</head>

<body class="container mx-auto mt-10 mb-10 max-w-3xl">
  @if (session()->has('success') || session()->has('error'))
  <div x-data="{open: true}" x-show="open" class="book-item relative mb-10 {{ session()->has('success') ? '!bg-green-100 !ring-green-500' : '!bg-red-100 !ring-red-500' }}">
    <p class="text-lg font-bold">{{ session()->has('success') ?  'Success' : 'Error' }}</p>
    <p>{{ session('success') ?: session('error') }}</p>

    <span @click="open = false" class="absolute top-0 bottom-0 right-0 p-4 cursor-pointer">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </span>
  </div>
  @endif
  @yield('content')
</body>

</html>