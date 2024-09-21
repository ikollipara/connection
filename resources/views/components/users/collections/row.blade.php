{{--
file: resources/views/components/users/collections/row.blade.php
author: Ian Kollipara
date: 2024-06-24
description: The HTML for a row in the user's collections table
 --}}

@props(['item'])

@php
  $title = (bool) $item->title ? $item->title : 'Unnamed Collection';
  $created_at = $item->created_at ? $item->created_at->diffForHumans() : 'Unknown';
  $updated_at = $item->updated_at ? $item->updated_at->diffForHumans() : 'Unknown';
  $archive_icon = $item->trashed() ? 'lucide-archive-restore' : 'lucide-archive';
@endphp

<tr class="is-clickable"
    x-data
    x-on:click="window.location.href = '{{ route('users.collections.edit', ['me', $item]) }}'">
  <td>
    <span class="tag is-link">{{ ucwords($item->status->label) }}</span>
  </td>
  <td>
    {{ $title }}
  </td>
  <td>{{ $created_at }}</td>
  <td>{{ $updated_at }}</td>
  <td class="buttons mb-0">
    @if ($item->published)
      <a class="button is-primary"
         href="{{ route('collections.show', $item) }}">
        <x-lucide-arrow-right class="icon"
                              width="30"
                              height="30"
                              fill="none" />
      </a>
    @endif
    <a class="button is-primary is-outlined"
       href="{{ route('users.collections.edit', ['me', $item]) }}">
      <x-lucide-pencil class="icon"
                       width="30"
                       height="30"
                       fill="none" />
    </a>
    <form action="{{ route('users.collections.update', ['me', $item]) }}"
          method="post">
      @csrf
      @method('PATCH')
      <input name="archive"
             type="hidden"
             value="{{ $item->trashed() ? '0' : '1' }}">
      <button class="button is-danger"
              type="submit">
        <x-icon :name="$archive_icon"
                :width="30"
                :height="30"
                fill="none" />
      </button>
    </form>
  </td>
