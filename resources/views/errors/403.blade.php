{{--
file: resources/views/errors/403.blade.php
author: Ian Kollipara
date: 2024-06-26
description: The HTML for the 403 error page
 --}}

@php
  $title = 'conneCTION - ' . __('Uh Oh!');
@endphp

<x-layout :title="$title"
          no-livewire>
  <x-hero class="is-primary has-text-centered">
    <h1 class="title is-1">{{ __('Uh Oh!') }}</h1>
  </x-hero>
  <x-container class="mt-5 has-text-centered">
    <p>
      {{ __('Looks like you are not allowed to access this page! Let\'s not do that.') }}
    </p>
    <x-errors.go-btn />
  </x-container>
</x-layout>
