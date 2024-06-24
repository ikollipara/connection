{{--
file: resources/views/users/posts/index.blade.php
author: Ian Kollipara
date: 2024-06-17
description: The HTML for the user's posts index page
 --}}

@php
  $status = ucfirst($status);
  $title = 'conneCTION - ' . auth()->user()->full_name . "'s {$status}  Posts";
  $is_archived = $status == 'archived';
@endphp

<x-layout :title="$title" no-livewire>
  <x-hero class="is-primary">
    <h1 class="title">{{ $status }} Posts</h1>
    <form x-data action="{{ url()->current() }}" method="get">
      <input type="hidden" name="status" value="{{ lcfirst($status) }}">
      <x-forms.input name="q" placeholder="Filter by Title..." value="{{ request('q') }}"
        x-on:change.debounce.300ms="$root.submit()" without-label />
    </form>
    @if ($is_archived)
      <p class="content">
        Archived posts are similar to unlisted videos, if someone has the link they can access. But the video is
        unsearchable.
      </p>
    @endif
  </x-hero>
  <x-container is-fluid class="mt-5">
    <x-table :items="$posts" row-component="users.posts.row"
      headers="Status, Title, Created At, Updated At, Actions" />
    {{ $posts->links('pagination') }}
  </x-container>
</x-layout>
