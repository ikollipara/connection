{{--
file: resources/views/components/add-to-collection.blade.php
author: Ian Kollipara
date: 2024-06-19
description: The HTML for the add to collection component
 --}}

@props(['content', 'collections'])

@php
  $content_collection_ids = $content->collections()->pluck('id');
  $in_collection = fn($collection) => $content_collection_ids->contains($collection->id) ? 'true' : 'false';
@endphp

<x-modal title="Add to Collection"
         no-delete>
  <x-slot class="is-primary"
          name="btn">
    <x-lucide-bookmark :width="24"
                       :height="24" />
  </x-slot>
  <form id="add-to-collections-form"
        action="{{ route('entries.toggle') }}"
        method="post">
    @csrf
    <input name="content_id"
           type="hidden"
           value="{{ $content->id }}">
    <x-table :items="$collections">
      @forelse ($collections as $item)
        <tr>
          <td>
            <button type="button"
                    x-data="{ checked: {{ $in_collection($item) }} }"
                    x-on:click="checked = !checked">
              <template x-if="checked">
                <input name="collections[]"
                       type="hidden"
                       value="{{ $item->id }}">
              </template>
              <x-lucide-check-circle class="has-text-success"
                                     x-show="checked"
                                     :width="24"
                                     :height="24" />
              <x-lucide-circle class="has-text-danger"
                               x-show="!checked"
                               :width="24"
                               :height="24" />
            </button>
          </td>
          <td>{{ $item->title }}</td>
        </tr>
      @empty
        <tr>
          <td>
            <p class="has-text-centered">No collections found.</p>
          </td>
        </tr>
      @endforelse
    </x-table>
    <x-slot name="footer">
    @empty($collections)
    @else
      <button class="button is-primary preserve-rounding"
              form="add-to-collections-form"
              type="submit">Done</button>
    @endempty
  </x-slot>
</form>
</x-modal>
