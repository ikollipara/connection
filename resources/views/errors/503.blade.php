{{--
file: resources/views/errors/503.blade.php
author: Ian Kollipara
date: 2024-06-10
description: This file contains the HTML for the 503 error page.
 --}}

@php
  $title = 'conneCTION - ' . __('Uh Oh!');
@endphp

<x-layout :title="$title" no-livewire>
  <x-hero class="is-primary has-text-centered">
    <h1 class="title is-1">{{ __('Uh Oh!') }}</h1>
  </x-hero>
  <x-container class="mt-5 has-text-centered">
    <p class="content is-large">
      {{ __('The server is currently down for maintenance. We are working to fix this issue as soon as possible. We are sorry for the inconvience!') }}
    </p>
  </x-container>
