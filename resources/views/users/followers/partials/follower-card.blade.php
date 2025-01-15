{{--
file: resources/views/users/followers/partials/follower-card.blade.php
author: Ian Kollipara
date: 2024-09-21
description: This file contains the HTML for a follower card.
 --}}

<div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 w-full">
  <a href="{{ route('users.profile.show', $user) }}">
    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $user->full_name }}</h5>
  </a>
  <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
    {{ $user->profile->short_title }}
  </p>
  <div class="flex gap-x-3">
    <a class="inline-flex font-medium items-center text-blue-600 hover:underline"
       href="{{ route('users.profile.show', $user) }}">
      Show Profile
    </a>
  </div>
</div>
