{{--
file: resources/views/error/404.blade.php
author: Ian Kollipara
date: 2024-06-10
description: This file contains the HTML for the 404 error page.
 --}}

@php
  $title = 'conneCTION - ' . __('Uh Oh!');
@endphp

<x-layout :title="$title" no-livewire>
  <x-hero class="is-primary has-text-centered">
    <h1 class="title is-1">{{ __('Uh Oh!') }}</h1>
  </x-hero>
  <x-container class="mt-5 has-text-centered">
    <p class="content is-large">{{ __('The page you are looking for does not exist.') }}</p>
    <x-errors.go-btn />
  </x-container>
</x-layout>
