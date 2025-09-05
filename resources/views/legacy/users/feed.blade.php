{{--
file: resources/views/users/feed.blade.php
author: Ian Kollipara
date: 2024-09-08
description: The user's feed of posts from other users.
 --}}

<x-authed-layout title="My Feed">
  <h1
      class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
    My Feed</h1>
  @forelse ($feed as $content)
    <section class="space-y-3">
      @include('users.partials.feed-card', [
          'content' => $content,
          'href' => route("{$content->type}s.show", $content),
      ])
    @empty
      <p>
        Looks like you don't have any posts in your feed yet. Follow some users to see their posts here!
      </p>
  @endforelse
  </section>
</x-authed-layout>
