{{--
file: resources/views/users/posts/partials/search-form.blade.php
author: Ian Kollipara
date: 2024-09-09
description: The search form for the user's posts
 --}}

<x-form class="mb-4"
        role="search"
        action="{{ url()->current() }}"
        x-data
        method="get">
  <input name="status"
         type="hidden"
         value="{{ request('status') }}">
  <x-form-input name="q"
                type="search"
                value="{{ request('q') }}"
                placeholder="Filter by Title..."
                x-on:input.debounce.300ms="$root.submit()" />
</x-form>
