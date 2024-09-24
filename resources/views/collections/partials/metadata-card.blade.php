{{--
file: resources/views/posts/partials/metadata-card.blade.php
author: Ian Kollipara
date: 2024-09-11
description: The metadata card for a post
 --}}

<dl class="text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
  <div class="flex flex-col pb-3 ms-3">
    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Grades</dt>
    <dd class="text-sm font-semibold">
      @foreach ($metadata->grades as $grade)
        <span
              class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $grade->value }}</span>
      @endforeach
    </dd>
  </div>
  <div class="flex flex-col py-3 ms-3">
    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Standards</dt>
    <dd class="text-sm font-semibold">
      @foreach ($metadata->standards as $standard)
        <span
              class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $standard->value }}</span>
        @unless ($loop->last)
          ,
        @endunless
      @endforeach
    </dd>
  </div>
  <div class="flex flex-col py-3 ms-3">
    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Practices</dt>
    <dd class="text-sm font-semibold">
      @foreach ($metadata->practices as $practice)
        <span
              class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $practice->label }}</span>
        @unless ($loop->last)
          ,
        @endunless
      @endforeach
    </dd>
  </div>
  <div class="flex flex-col py-3 ms-3">
    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Languages</dt>
    <dd class="text-sm font-semibold">
      @foreach ($metadata->languages as $language)
        <span
              class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $language->label }}</span>
        @unless ($loop->last)
          ,
        @endunless
      @endforeach
    </dd>
  </div>
  <div class="flex flex-col py-3 ms-3">
    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Category</dt>
    <dd class="text-sm font-semibold">
      <span
            class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $metadata->category->label }}</span>
    </dd>
  </div>
  <div class="flex flex-col py-3 ms-3">
    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Audience</dt>
    <dd class="text-sm font-semibold">
      <span
            class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $metadata->audience->label }}</span>
    </dd>
  </div>
</dl>
