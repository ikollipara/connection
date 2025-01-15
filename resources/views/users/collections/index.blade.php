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

{{-- @php
  $status = ucfirst($status);
  $title = 'conneCTION - ' . auth()->user()->full_name . "'s {$status} Collections";
  $is_archive = $status == 'Archived';
@endphp

<x-layout :title="$title"
          no-livewire>
  <x-hero class="is-primary">
    <h1 class="title">{{ $status }} Collections</h1>
    <form x-data
          action="{{ url()->current() }}"
          method="get">
      <input name="status"
             type="hidden"
             value="{{ lcfirst($status) }}">
      <x-forms.input name="q"
                     value="{{ request('q') }}"
                     placeholder="Filter by Title..."
                     x-on:change.debounce.300ms="$root.submit()"
                     without-label />
    </form>
    @if ($is_archive)
      <p class="content">
        Archived collections are similar to unlisted videos, if someone has the link they can access. But the
        video is unsearchable.
      </p>
    @endif
  </x-hero>
  <x-container class="mt-5"
               is-fluid>
    <x-table :items="$collections"
             row-component="users.collections.row"
             headers="Status, Title, Created At, Updated At, Actions" />
    {{ $collections->links('pagination') }}
  </x-container>
</x-layout> --}}
