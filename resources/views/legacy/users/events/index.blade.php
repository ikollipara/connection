{{-- <x-layout>
  <x-hero class="is-primary">
    <h1 class="title">My Events</h1>
  </x-hero>
  {{ $events->links('pagination') }}
  @forelse ($events as $event)
    @include('users.events.partials.event-detail', ['event' => $event])
  @empty
    <p>No events found.</p>
  @endforelse
</x-layout> --}}

{{--
file: resources/views/users/events/index.blade.php
author: Ian Kollipara
date: 2024-09-23
description: The HTML for the user's events index page
 --}}

<x-authed-layout title="My Events">
  <x-title label="My Events" />
  @include('users.events.partials.search-form')
  <section class="space-y-3">
    @forelse ($events as $event)
      @include('users.events.partials.event-card', [
          'event' => $event,
      ])
    @empty
      @if (request('q'))
        <p>
          No events found for "{{ request('q') }}". Try a different search term.
        </p>
      @else
        <p>
          Looks like you don't have any events yet. Create a new event to get started!
        </p>
        <a href="{{ route('users.events.create', 'me') }}">Create an Event</a>
      @endif
    @endforelse
  </section>
  {{ $events->links() }}
</x-authed-layout>
