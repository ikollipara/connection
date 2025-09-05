{{--
file: resources/views/users/collections/index.blade.php
author: Ian Kollipara
date: 2024-06-24
description: Collections index view for a user
 --}}

@php
  $isArchived = $status == 'archived';
@endphp

<x-authed-layout title="My {{ ucwords($status) }} Collections">
  <x-title label="My {{ ucwords($status) }} Collections" />
  @include('users.collections.partials.search-form')
  @includeIf($isArchived, 'users.collections.partials.archive-notice')
  <section class="space-y-3">
    @forelse ($collections as $collection)
      @include('users.collections.partials.collection-card', [
          'collection' => $collection,
      ])
    @empty
      @if (request('q'))
        <p>
          No {{ strtolower($status) }} collections found for "{{ request('q') }}". Try a different search term.
        </p>
      @else
        <p>
          Looks like you don't have any {{ strtolower($status) }} collections yet. Create a new collection to get
          started!
        </p>
        <a href="{{ route('users.collections.create', 'me') }}">Create a Collection</a>
      @endif
    @endforelse
  </section>
  {{ $collections->links() }}
</x-authed-layout>
