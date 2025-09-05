{{--
file: resources/views/collections/show.blade.php
author: Ian Kollipara
date: 2024-06-24
description: The view for showing a collection
 --}}

<x-reading-layout title="{{ $collection->title }}">
  @push('scripts')
    <script>
      window.body = JSON.stringify({{ $collection->body->toJson(parse: true) }});
    </script>
  @endpush
  <x-slot:aside>
    @include('collections.partials.details-sidebar', ['collection' => $collection])
  </x-slot>
  <main class="flex flex-col gap-y-3">
    <x-title label="{{ $collection->title }}" />
    @include('collections.partials.action-bar', ['collection' => $collection])
    <div x-data="editor({ name: 'name', readOnly: true, canUpload: true, csrf: '{{ csrf_token() }}', body: window.body })">
      <input name="name"
             type="hidden"
             x-bind="input">
      <div x-bind="editor"></div>
    </div>
    @include('users.collections.partials.entries', ['collection' => $collection])
  </main>
</x-reading-layout>
