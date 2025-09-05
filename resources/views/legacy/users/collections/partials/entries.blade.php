{{--
file: resources/views/users/collections/partials/entries.blade.php
author: Ian Kollipara
date: 2024-09-16
description: The HTML for the entries section of a collection
 --}}

<hr>
<h2 class="text-3xl font-bold dark:text-white py-3">Entries</h2>
@forelse ($collection->entries as $entry)
  @include('users.collections.partials.entry-card', [
      'post' => $entry,
      'editable' => request()->routeIs('users.collections.*'),
  ])
@empty
  @if (request()->routeIs('users.collections.*'))
    <p>No Entries yet. Add some!</p>
  @else
    <p>No Entries found.</p>
  @endif
@endforelse
