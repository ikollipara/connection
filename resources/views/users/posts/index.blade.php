{{--
file: resources/views/users/posts/index.blade.php
author: Ian Kollipara
date: 2024-06-17
description: The HTML for the user's posts index page
 --}}

@php
  $status = ucfirst($status);
  $isArchived = $status == 'Archived';
@endphp

<x-authed-layout title="My {{ $status }} Posts">
  <x-title label="My {{ $status }} Posts" />
  @include('users.posts.partials.search-form')
  @includeIf($isArchived, 'users.posts.partials.archive-notice')
  <section class="space-y-3">
    @forelse ($posts as $post)
      @include('users.posts.partials.post-card', [
          'post' => $post,
      ])
    @empty
      @if (request('q'))
        <p>
          No {{ strtolower($status) }} posts found for "{{ request('q') }}". Try a different search term.
        </p>
      @else
        <p>
          Looks like you don't have any {{ strtolower($status) }} posts yet. Create a new post to get started!
        </p>
        <a href="{{ route('users.posts.create', 'me') }}">Create a Post</a>
      @endif
    @endforelse
  </section>
  {{ $posts->links() }}
</x-authed-layout>

{{-- @php
  $status = ucfirst($status);
  $title = 'conneCTION - ' . auth()->user()->full_name . "'s {$status}  Posts";
  $is_archived = $status == 'archived';
@endphp

<x-layout :title="$title"
          no-livewire>
  <x-hero class="is-primary">
    <h1 class="title">{{ $status }} Posts</h1>
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
    @if ($is_archived)
      <p class="content">
        Archived posts are similar to unlisted videos, if someone has the link they can access. But the video is
        unsearchable.
      </p>
    @endif
  </x-hero>
  <x-container class="mt-5"
               is-fluid>
    <x-table :items="$posts"
             row-component="users.posts.row"
             headers="Status, Title, Created At, Updated At, Actions" />
    {{ $posts->links('pagination') }}
  </x-container>
</x-layout> --}}
