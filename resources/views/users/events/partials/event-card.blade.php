{{--
file: resources/views/users/events/partials/event-card.blade.php
author: Ian Kollipara
date: 2024-09-23
description: The card for an event
 --}}

<div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-full">
  <a href="{{ route('users.events.edit', ['me', $event]) }}">
    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $event->title }}</h5>
  </a>
  <div class="flex gap-x-3">
    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
      Last Updated {{ $event->updated_at->diffForHumans() }}
    </p>
    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
      {{ $event->attendees_count }} {{ Str::plural('Attendee', $event->attendees_count) }}
    </p>
    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
      {{ $event->days_count }} {{ Str::plural('Day', $event->days_count) }}
    </p>
    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
      {{ $event->start->format('H:m A') }} - {{ $event->end->format('H:m A') }}
    </p>
  </div>
  <div class="flex gap-x-3">
    <a class="inline-flex font-medium items-center text-blue-600 hover:underline"
       href="{{ route('users.events.edit', ['me', $event]) }}">
      Edit
    </a>
    <a class="inline-flex font-medium items-center text-blue-600 hover:underline"
       href="{{ route('events.show', $event) }}">
      View
    </a>
    @unless ($event->attendees_count > 0)
      <x-form class="inline"
              form-name="delete-post"
              action="{{ route('users.events.destroy', ['me', $event]) }}"
              method="delete">
        <button class="inline-flex font-medium items-center text-blue-600 hover:underline"
                type="submit">
          Delete
        </button>
      </x-form>
    @endunless
  </div>
</div>
