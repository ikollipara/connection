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
