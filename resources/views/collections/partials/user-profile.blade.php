{{--
file: resources/views/posts/partials/user-profile.blade.php
author: Ian Kollipara
date: 2024-09-16
description: The user profile for a post
 --}}

<div class="flex items-center gap-4">
  <img class="w-10 h-10 rounded-full"
       src="{{ $user->avatar }}"
       alt="{{ $user->full_name }}">
  <div class="font-medium dark:text-white">
    <div>{{ $user->full_name }}</div>
    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->profile->short_title }}</div>
  </div>
</div>
