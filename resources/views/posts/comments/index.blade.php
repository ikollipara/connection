{{--
file: resources/views/posts/comments/index.blade.php
author: Ian Kollipara
date: 2024-06-24
description: Comments index view for a post
 --}}

@php
  $title = 'conneCTION - ' . $post->title . ' Comments';
@endphp

<x-layout :title="$title" no-livewire>
  <x-hero class="is-primary" hero-body-class="level is-justify-content-between is-align-items-center">
    <div>
      <a href="{{ route('posts.show', $post) }}">
        <x-bulma-icon icon="lucide-arrow-left" size="is-medium" class="is-primary">
          Go Back
        </x-bulma-icon>
      </a>
      <h1 class="title is-1">Comments for <em>{{ $post->title }}</em></h1>
    </div>
    <x-comments.create-form :action="route('posts.comments.store', ['post' => $post])">
      <input type="hidden" name="user_id" value="{{ auth()->id() }}">
    </x-comments.create-form>
  </x-hero>
  <x-container is-fluid class="mt-5">
    @forelse ($comments as $comment)
      <x-comments.comment :comment="$comment" media-class="block" />
    @empty
      <p class="content is-medium has-text-centered">No comments yet.</p>
    @endforelse
    {{ $comments->links('pagination') }}
  </x-container>
</x-layout>
