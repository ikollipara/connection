{{--
file: resources/views/events/index.blade.php
author: Ian Kollipara
date: 2024-07-29
description: The view for the events index page.
 --}}

<x-layout title="conneCTION - Calendar">
  @dump($events->map(fn($event) => $event->toFullCalendar(auth()->user())))
  <x-hero class="is-primary">
    <h1 class="title">Calendar</h1>
    <p class="subtitle">Stay up-to-date with all the events happening on conneCTION.</p>
  </x-hero>
  @include('users.events._calendar')
</x-layout>
