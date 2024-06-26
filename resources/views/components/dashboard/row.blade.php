{{--
file: resources/views/components/dashboard/row.blade.php
author: Ian Kollipara
date: 2024-06-17
description: The HTML for a row in the dashboard
 --}}

@props(['item'])

@php
  $title = $item->title ?? 'Unnamed ' . ucfirst($item->type);
  $has_user = $item->user;
  $route = $item->type === 'post' ? 'posts.show' : 'collections.show';
@endphp

<tr>
  <td><span class="tag is-link">{{ ucfirst($item->type) }}</span></td>
  <td>{{ $title }}</td>
  <td>
    @if ($has_user)
      <a href="{{ route('users.show', $item->user) }}" class="link">{{ $item->user->full_name }}</a>
    @else
      [Deleted]
    @endif
  </td>
  <td>
    <x-bulma-icon icon="lucide-eye">{{ $item->views_count }}</x-bulma-icon>
  </td>
  <td>
    <x-bulma-icon icon="lucide-heart">{{ $item->likes_count }}</x-bulma-icon>
  </td>
  <td><a href="{{ route($route, $item) }}">Visit</a></td>
</tr>
