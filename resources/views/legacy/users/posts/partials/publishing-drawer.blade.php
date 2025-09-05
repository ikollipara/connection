{{--
file: resources/views/users/posts/partials/publishing-drawer.blade.php
author: Ian Kollipara
date: 2024-09-09
description: The drawer for publishing a post
 --}}

@php
  use App\Enums\Audience;
  use App\Enums\Category;
  use App\Enums\Grade;
  use App\Enums\Language;
  use App\Enums\Practice;
  use App\Enums\Standard;
@endphp

<div class="fixed top-0 left-0 z-40 w-96 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800"
     id="{{ $name }}"
     aria-labelledby="{{ $name }}-label"
     tabindex="-1">
  <h5 class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400"
      id="{{ $name }}-label">Post Details</h5>
  <button class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
          data-drawer-hide="{{ $name }}"
          type="button"
          aria-controls="{{ $name }}">
    <svg class="w-5 h-5"
         aria-hidden="true"
         fill="currentColor"
         viewBox="0 0 20 20"
         xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd"
            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
            clip-rule="evenodd"></path>
    </svg>
    <span class="sr-only">Close menu</span>
  </button>
  <x-form class="py-4 overflow-y-auto"
          action="{{ $action }}"
          method="{{ $method }}"
          x-data
          x-on:editor:saved.window="$el.action = $event.detail.action; $refs.method.value = $event.detail.method"
          :model="$post">
    <ul class="space-y-2 font-medium">
      <li>
        <x-form-select name="audience"
                       :selected="$post->metadata->audience"
                       :options="Audience::cases()" />
      </li>
      <li>
        <x-form-select name="grades"
                       :options="Grade::cases()"
                       :selected="$post->metadata->grades"
                       multiple />
      </li>
      <li>
        <x-form-select name="languages"
                       :options="Language::cases()"
                       :selected="$post->metadata->languages"
                       multiple />
      </li>
      <li>
        <x-form-select name="category"
                       :selected="$post->metadata->category"
                       :options="Category::cases()" />
      </li>
      <li>
        <x-form-select name="practices"
                       :selected="$post->metadata->practices"
                       :options="Practice::cases()"
                       multiple />
      </li>
      <li>
        <x-form-select name="standards"
                       :selected="$post->metadata->standards"
                       :options="Standard::cases()"
                       multiple />
      </li>
      <li>
        <x-form-submit label="Publish Post" />
      </li>
    </ul>
  </x-form>
</div>
