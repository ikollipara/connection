{{--
file: resources/views/search/partials/post-result.blade.php
author: Ian Kollipara
date: 2024-09-24
description: The post result for the search form
 --}}

<a class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
   href="{{ $href }}">
  <div class="flex flex-col justify-between p-4 leading-normal">
    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
      {{ empty($content->title) ? 'Untitled' : $content->title }}
    </h5>
    {{-- <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
      {{ Str::limit(strip_tags($content->body->toHtml()), 10) }}
    </p> --}}
    <div class="flex gap-x-3">
      <p class="inline-flex font-medium items-center text-gray-600">
        By {{ $content->user->full_name }}
      </p>
      <p class="inline-flex font-medium items-center text-gray-600">
        {{ $content->views() }} Views
      </p>
      <p class="inline-flex font-medium items-center text-gray-600">
        {{ $content->likes() }} Likes
      </p>
    </div>
  </div>
</a>
