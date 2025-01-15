{{--
file: resources/views/components/help.blade.php
author: Ian Kollipara
date: 2024-06-17
description: The HTML for a help button
 --}}

@props(['title'])

<x-modal :title="$title">
  <x-slot:btn
          class="is-primary">
    <x-lucide-help-circle class="icon" />
  </x-slot>
  {{ $slot }}
</x-modal>
