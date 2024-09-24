{{--
file: resources/views/components/layouts/guest.blade.php
author: Ian Kollipara
date: 2024-07-26
description: The HTML for the guest layout
 --}}

@props(['title'])

<x-layouts.app title="{{ $title }}"
               {{ $attributes }}>
  <x-navbar />
  {{ $slot }}

</x-layouts.app>
