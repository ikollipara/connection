{{--
file: resources/views/posts/show.blade.php
author: Ian Kollipara
date: 2024-06-24
description: Show view for a post
 --}}

<x-reading-layout title="{{ $post->title }}">
  @push('scripts')
    <script>
      window.body = JSON.stringify({{ $post->body->toJson(parse: true) }});
    </script>
  @endpush
  <x-slot:aside>
    @include('posts.partials.details-sidebar', ['post' => $post])
  </x-slot>
  <main class="flex flex-col gap-y-3">
    <x-title>{{ $post->title }}</x-title>
    @include('posts.partials.action-bar', ['post' => $post])
    <div x-data="editor({ name: 'name', readOnly: true, canUpload: true, csrf: '{{ csrf_token() }}', body: window.body })">
      <input name="name"
             type="hidden"
             x-bind="input">
      <div x-bind="editor"></div>
    </div>
  </main>
</x-reading-layout>
