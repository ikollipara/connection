{{--
file: resources/views/users/posts/partials/post-card.blade.php
author: Ian Kollipara
date: 2024-09-09
description: The card for a user's post
 --}}

@php
  use App\Enums\Status;
@endphp

<div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-full">
  <a href="{{ route('users.posts.edit', ['me', $post]) }}">
    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $post->title }}</h5>
  </a>
  <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
    Last Updated {{ $post->updated_at->diffForHumans() }}
  </p>
  <div class="flex gap-x-3">
    <a class="inline-flex font-medium items-center text-blue-600 hover:underline"
       href="{{ route('users.posts.edit', ['me', $post]) }}">
      Edit
    </a>
    <a class="inline-flex font-medium items-center text-blue-600 hover:underline"
       href="{{ route('posts.show', $post) }}">
      View
    </a>
    <x-form class="inline"
            action="{{ route('users.posts.status', ['me', $post]) }}"
            method="patch">
      <input name="status"
             type="hidden"
             value="{{ $post->status->equals(Status::archived()) ? Status::published() : Status::archived() }}">
      <button class="inline-flex font-medium items-center text-blue-600 hover:underline"
              type="submit">
        @if ($post->status->equals(Status::archived()))
          Restore
        @else
          Delete
        @endif
      </button>
    </x-form>
  </div>
</div>
