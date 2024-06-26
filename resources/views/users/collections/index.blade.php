{{--
file: resources/views/users/collections/index.blade.php
author: Ian Kollipara
date: 2024-06-24
description: Collections index view for a user
 --}}

@php
  $status = ucfirst($status);
  $title = 'conneCTION - ' . auth()->user()->full_name . "'s {$status} Collections";
  $is_archive = $status == 'Archived';
@endphp

<x-layout :title="$title" no-livewire>
  <x-hero class="is-primary">
    <h1 class="title">{{ $status }} Collections</h1>
    <form x-data action="{{ url()->current() }}" method="get">
      <input type="hidden" name="status" value="{{ lcfirst($status) }}">
      <x-forms.input name="q" placeholder="Filter by Title..." value="{{ request('q') }}"
        x-on:change.debounce.300ms="$root.submit()" without-label />
    </form>
    @if ($is_archive)
      <p class="content">
        Archived collections are similar to unlisted videos, if someone has the link they can access. But the
        video is unsearchable.
      </p>
    @endif
  </x-hero>
  <x-container is-fluid class="mt-5">
    <x-table :items="$collections" row-component="users.collections.row"
      headers="Status, Title, Created At, Updated At, Actions" />
    {{ $collections->links('pagination') }}
  </x-container>
</x-layout>
