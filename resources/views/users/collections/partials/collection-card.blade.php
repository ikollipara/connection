{{--
file: resources/views/users/collections/partials/post-card.blade.php
author: Ian Kollipara
date: 2024-09-09
description: The card for a user's post
 --}}

@php
  use App\Enums\Status;
@endphp

<div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-full">
  <a href="{{ route('users.collections.edit', ['me', $collection]) }}">
    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $collection->title }}</h5>
  </a>
  <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
    Last Updated {{ $collection->updated_at->diffForHumans() }}
  </p>
  <div class="flex gap-x-3">
    <a class="inline-flex font-medium items-center text-blue-600 hover:underline"
       href="{{ route('users.collections.edit', ['me', $collection]) }}">
      Edit
    </a>
    <a class="inline-flex font-medium items-center text-blue-600 hover:underline"
       href="{{ route('collections.show', $collection) }}">
      View
    </a>
    <x-form class="inline"
            form-name="delete-collection"
            action="{{ route('users.collections.status', ['me', $collection]) }}"
            method="patch">
      <input name="status"
             type="hidden"
             value="{{ $collection->status->equals(Status::archived()) ? Status::published() : Status::archived() }}">
      <button class="inline-flex font-medium items-center text-blue-600 hover:underline"
              type="submit">
        @if ($collection->status->equals(Status::archived()))
          Restore
        @else
          Delete
        @endif
      </button>
    </x-form>
  </div>
</div>
