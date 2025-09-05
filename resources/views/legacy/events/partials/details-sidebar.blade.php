{{--
file: resources/views/events/partials/details-sidebar.blade.php
author: Ian Kollipara
date: 2024-09-16
description: The details sidebar for an event
 --}}

<aside class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
       id="logo-sidebar"
       aria-label="Sidebar">
  <h2 class="text-3xl font-bold dark:text-white text-center pb-3">Details</h2>
  <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
    <ul class="space-y-2 font-medium">
      <li>
        @include('posts.partials.user-profile', ['user' => $event->user])
      </li>
      @include('posts.partials.metadata-card', ['metadata' => $event->metadata])
      <div class="flex flex-col ms-3 pb-3">
        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Time</dt>
        <dd class="text-sm font-semibold">
          <span
                class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $event->start->format('H:i A') }}{{ filled($event->end) ? ' - ' . $event->end->format('H:i A') : '' }}</span>
        </dd>
      </div>
      <div class="flex flex-col ms-3 pb-3">
        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Days</dt>
        <dd class="text-sm font-semibold">
          @foreach ($event->days as $day)
            <span
                  class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $day->date->toFormattedDateString() }}</span>
          @endforeach
        </dd>
      </div>
      </li>
      <div class="flex flex-col ms-3 pb-3">
        <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">
          {{ $event->attendees()->count() }}
          {{ Str::plural('Attendee', $event->attendees()->count()) }}
        </dt>
        <dd class="text-sm font-semibold">
          @foreach ($event->attendees as $attendee)
            <a class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300"
               href="{{ route('users.profile.show', $attendee) }}">{{ $attendee->full_name }}</a><br>
          @endforeach
        </dd>
      </div>
    </ul>
  </div>
</aside>
