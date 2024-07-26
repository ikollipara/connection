{{--
file: resources/views/components/users/posts/unsaved-indicator.blade.php
author: Ian Kollipara
date: 2024-06-17
description: The HTML for an unsaved indicator for posts
 --}}

@props([
    'showUnsavedOn' => 'editor:unsaved',
    'showSavedOn' => 'editor:saved',
])

<span class="mt-auto mb-auto" x-data="{ saved: true }" x-on:{{ $showUnsavedOn }}.document="saved = false"
  x-on:{{ $showSavedOn }}.document="saved = true">
  <span class="icon" x-bind:class="{ 'has-text-success': saved, 'has-text-danger': !saved }">
    <x-lucide-x x-show="!saved" x-cloak title="Unsaved!" />
    <x-lucide-check x-show="saved" x-cloak title="Saved!" />
  </span>
</span>
