{{--
file: resources/views/posts/partials/user-profile.blade.php
author: Ian Kollipara
date: 2024-09-16
description: The user profile for a post
 --}}

@php
  $avatar = $user?->avatar ?? 'https://ui-avatars.com/api/?name=Deleted&color=7F9CF5&background=EBF4FF';
  $full_name = $user?->full_name ?? '[Deleted]';
  $short_title = $user?->profile->short_title ?? '[Deleted]';
@endphp

<div class="flex items-center gap-4">
  <img class="w-10 h-10 rounded-full"
       src="{{ $avatar }}"
       alt="{{ $full_name }}">
  <div class="font-medium dark:text-white">
    <div>{{ $full_name }}</div>
    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $short_title }}</div>
  </div>
</div>
