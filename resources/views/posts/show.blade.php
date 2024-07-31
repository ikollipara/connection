{{--
file: resources/views/posts/show.blade.php
author: Ian Kollipara
date: 2024-06-24
description: Show view for a post
 --}}

@php
  $title = "conneCTION - {$post->title}";
  $avatar = $post->user ? $post->user->avatar : 'https://ui-avatars.com/api/?name=Deleted&color=7F9CF5&background=EBF4FF';
  $full_name = $post->user ? $post->user->full_name : 'Deleted';
  $short_title = $post->user ? $post->user->profile->short_title : '';
  $route = $liked_by_user ? route('content.likes.destroy', [$post, $liked_by_user->id]) : route('content.likes.store', $post);
@endphp

<x-layout :title="$title"
          no-livewire>
  @push('meta')
    <meta name="description"
          content="{{ Str::limit($post->body_text, 150) }}">
    <meta name="og:title"
          content="{{ $title }}">
    <meta name="og:description"
          content="{{ Str::limit($post->body_text, 150) }}">
    <meta name="og:image"
          content="{{ $avatar }}">
  @endpush
  <x-hero class="is-primary"
          hero-body-class="has-text-centered">
    <h1 class="title is-1">{{ $post->title }}</h1>
    <div class="column is-flex is-flex-direction-column is-align-items-center is-justify-content-center">
      <figure class="image is-64x64"><img src="{{ $avatar }}"
             alt=""></figure>
      <a class="link is-italic"
         @if ($post->user) href="{{ route('users.show', $post->user) }}" @endif>
        {{ $full_name }} - {{ $short_title }}
      </a>
    </div>
    <div class="level bordered">
      <div class="level-left">
        <x-bulma-icon icon="lucide-eye">{{ $post->views_count }}</x-bulma-icon>
        <form action="{{ $route }}"
              method="post">
          @csrf
          @method($liked_by_user ? 'DELETE' : 'POST')
          <input name="user_id"
                 type="hidden"
                 value="{{ auth()->id() }}">
          <button class="button is-primary"
                  type="submit">
            <x-bulma-icon fill="{{ $liked_by_user ? 'white' : 'none' }}"
                          icon="lucide-heart">{{ $post->likes_count }}</x-bulma-icon>
          </button>
        </form>
      </div>
      <div class="level-right">
        <x-add-to-collection :content="$post"
                             :collections="auth()->user()->collections" />
        <a class="button is-primary"
           href="{{ route('posts.comments.index', $post) }}">See Comments</a>
      </div>
    </div>
  </x-hero>
  <x-container class="my-5"
               is-fluid>
    <details class="is-clickable">
      <summary>Metadata</summary>
      <x-metadata.table :metadata="$post->metadata" />
    </details>
    <div class="container content">
      {{ $post->body }}
    </div>
  </x-container>
</x-layout>
