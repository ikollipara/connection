{{--
file: resources/views/events/index.blade.php
author: Ian Kollipara
date: 2024-07-29
description: The view for the events index page.
 --}}

@php
  $mine ??= false;
@endphp

<x-authed-layout title="Upcoming Events">
  <x-title label="Upcoming Events" />
  @if ($mine)
    <div x-data="calendar({ user: '{{ auth()->id() }}' })"></div>
  @else
    <div x-data="calendar({ user: null })"></div>
  @endif
</x-authed-layout>

{{-- <x-layout title="conneCTION - Calendar">
  @dump($events->map(fn($event) => $event->toFullCalendar(auth()->user())))
  <x-hero class="is-primary">
    <h1 class="title">Calendar</h1>
    <p class="subtitle">Stay up-to-date with all the events happening on conneCTION.</p>
  </x-hero>
  @include('users.events._calendar')
</x-layout> --}}
