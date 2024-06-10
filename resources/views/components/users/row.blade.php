{{--
file: resources/views/components/users/row.blade.php
author: Ian Kollipara
date: 2024-06-06
description: This file contains the HTML for displaying a user's row.
 --}}

@props(['user'])

<tr class="is-clickable" x-on:click="window.location.href = '{{ route('users.show', $user) }}'">
  <td>{{ $user->full_name }}</td>
  <td>
    <span class="icon-text">
      <span class="icon">
        <x-lucide-newspaper class="icon" width="30" height="30" fill="none" />
      </span>
      <span>{{ $user->posts_count ?? $user->posts()->count() }}</span>
    </span>
  </td>
  <td>
    <span class="icon-text">
      <span class="icon">
        <x-lucide-layers class="icon" width="30" height="30" fill="none" />
      </span>
      <span>{{ $user->collections_count ?? $user->collections()->count() }}</span>
    </span>
  </td>
  <td>
    <a href="{{ route('users.show', $user) }}" class="is-link">See Profile</a>
  </td>
</tr>
