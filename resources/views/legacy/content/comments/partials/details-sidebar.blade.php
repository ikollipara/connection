{{--
file: resources/views/content/comments/partials/details-sidebar.blade.php
author: Ian Kollipara
date: 2024-09-16
description: The details sidebar for a comment
 --}}

<aside class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
       id="logo-sidebar"
       aria-label="Sidebar">
  <h2 class="text-3xl font-bold dark:text-white text-center pb-3">{{ $content->title }}</h2>
  <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
    <ul class="space-y-2 font-medium">
      <li>
        @include('posts.partials.user-profile', ['user' => $content->user])
      </li>
      @include('posts.partials.metadata-card', ['metadata' => $content->metadata])
      </li>
    </ul>
  </div>
</aside>
