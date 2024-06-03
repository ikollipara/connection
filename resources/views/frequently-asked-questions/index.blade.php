{{--
file: resources/views/frequently-asked-questions/index.blade.php
author: Ian Kollipara
date: 2024-06-03
description: Frequently Asked Questions (FAQ) page
--}}

@php
  $title = 'conneCTION' . __('Frequently Asked Questions');
@endphp

<x-layout :title="$title">
  @livewire('search-frequently-asked-questions')
</x-layout>
