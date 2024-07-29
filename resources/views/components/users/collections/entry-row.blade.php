{{--
file: resources/views/components/users/collections/entry-row.blade.php
author: Ian Kollipara
date: 2024-06-24
description: The HTML for a row in the user's collections table
 --}}

@props(['item', 'collection'])

@php
  $title = (bool) $item->title ? $item->title : 'Unnamed';
  $full_name = $item->user ? $item->user->full_name : '[Deleted]';
@endphp

<tr x-data>
  <td><span class="tag is-link">{{ ucwords($item->type) }}</span></td>
  <td>{{ $title }}</td>
  <td>{{ $full_name }}</td>
  <td>
    <x-bulma-icon icon="lucide-heart">{{ $item->likes_count }}</x-bulma-icon>
  </td>
  <td>
    <x-bulma-icon icon="lucide-eye">{{ $item->views_count }}</x-bulma-icon>
  </td>
  <td>
    <x-modal title="Delete Entry"
             btn-delete>
      <form id="delete-{{ $item->pivot->id }}-entry-form"
            action="{{ route('collections.entries.destroy', [$item->pivot->collection_id, $item->pivot->id]) }}"
            method="post">
        @csrf
        @method('DELETE')
        <p class="content">
          Are you sure you want to delete this entry?<br>
          This action cannot be undone.
        </p>
      </form>
      <x-slot name="footer">
        <button class="button is-danger"
                form="delete-{{ $item->pivot->id }}-entry-form"
                type="submit">Delete</button>
      </x-slot>
    </x-modal>
  </td>
</tr>
