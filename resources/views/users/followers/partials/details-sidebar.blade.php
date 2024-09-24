{{--
file: resources/views/users/followers/partials/details-sidebar.blade.php
author: Ian Kollipara
date: 2024-09-21
description: The details sidebar for a user's followers
 --}}

<aside class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
       id="logo-sidebar"
       aria-label="Sidebar">
  <h2 class="text-3xl font-bold dark:text-white text-center pb-3">{{ $title }}</h2>
  <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
    <ul class="space-y-2 font-medium">
      <li>
        <a class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
           href="{{ route('users.profile.show', $user) }}">
          <x-lucide-arrow-left
                               class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
          <span class="flex-1 ms-3 whitespace-nowrap">Back to Profile</span>
        </a>
      </li>
      <li>
        @include('posts.partials.user-profile', ['user' => $user])
      </li>
    </ul>
  </div>
</aside>
