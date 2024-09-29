{{--
file: resources/views/users/collections/partials/entry-card.blade.php
author: Ian Kollipara
date: 2024-09-16
description: The card for a user's collection entry
 --}}

@php
  use App\Enums\Status;
@endphp

<div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-full">
  <a href="{{ route('posts.show', $post) }}">
    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $post->title }}</h5>
  </a>
  <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
    Last Updated {{ $post->updated_at->diffForHumans() }}
  </p>
  <div class="flex gap-x-3">
    <a class="inline-flex font-medium items-center text-blue-600 hover:underline"
       href="{{ route('posts.show', $post) }}">
      View
    </a>
    @if ($editable)
      <x-form action="{{ route('users.collections.entries.destroy', ['me', $collection, $post->pivot->id]) }}"
              method="delete">
        <button class="inline-flex font-medium items-center text-blue-600 hover:underline"
                type="submit">
          Remove
        </button>
      </x-form>
    @endif
  </div>
</div>
