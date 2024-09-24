{{--
file: resources/views/users/events/partials/search-form.blade.php
author: Ian Kollipara
date: 2024-09-23
description: The search form for the user's events
 --}}

<x-form class="mb-4"
        form-name="events--search"
        role="search"
        method="get"
        x-data
        action="{{ url()->current() }}">
  <x-form-input name="q"
                type="search"
                value="{{ request('q') }}"
                x-on:input.debounce.300ms="$root.submit()"
                placeholder="Filter by Title..." />
</x-form>
