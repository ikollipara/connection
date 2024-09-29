{{--
file: resources/views/content/comments/partials/comment-form.blade.php
author: Ian Kollipara
date: 2024-09-22
description: The comment form for a content
 --}}

@php
  $parent_id ??= null;
@endphp

<x-form class="mb-6"
        action="{{ $action }}"
        method="post">
  <input name="user_id"
         type="hidden"
         value="{{ auth()->id() }}">
  <input name="parent_id"
         type="hidden"
         value="{{ $parent_id ?? '' }}">
  <div
       class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <label class="sr-only"
           for="comment">Your comment</label>
    <textarea class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
              id="comment"
              name="body"
              rows="6"
              placeholder="Write a comment..."
              required></textarea>
  </div>
  <x-form-submit label="Post comment" />
</x-form>
