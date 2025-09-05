{{--
file: resources/events/show.blade.php
author: Ian Kollipara
date: 2024-09-23
description: The HTML for the event show page
 --}}

<x-reading-layout title="{{ $event->title }}">
  @push('scripts')
    <script>
      window.body = JSON.stringify({{ $event->description->toJson(parse: true) }});
    </script>
  @endpush
  <x-slot:aside>
    @include('events.partials.details-sidebar', ['event' => $event])
  </x-slot>
  <main class="flex flex-col gap-y-3">
    <x-title label="{{ $event->title }}" />
    @include('events.partials.action-bar', ['event' => $event])
    <div x-data="editor({ name: 'name', readOnly: true, canUpload: true, csrf: '{{ csrf_token() }}', body: window.body })">
      <input name="name"
             type="hidden"
             x-bind="input">
      <div x-bind="editor"></div>
    </div>
  </main>
</x-reading-layout>
