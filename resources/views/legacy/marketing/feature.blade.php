{{--
file: resources/views/marketing/feature.blade.php
author: Ian Kollipara
date: 2024-09-08
description: A reusable feature partial for the marketing page
 --}}

<div>
  <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-blue-100 lg:h-12 lg:w-12 dark:bg-blue-900">
    <x-dynamic-component class="w-5 h-5 text-blue-600 lg:w-6 lg:h-6 dark:text-blue-300"
                         :component="$component" />

  </div>
  <div class="flex gap-x-3 items-center">
    <h3 class="mb-2 text-xl font-bold dark:text-white">{{ $name }}</h3>
    @isset($new)
      <span
            class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
        New
      </span>
    @endisset
  </div>
  <p class="text-gray-500 dark:text-gray-400">
    {{ $description }}
  </p>
</div>
