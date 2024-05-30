{{--
file: resources/views/components/lazy.blade.php
author: Ian Kollipara
date: 2024-05-27
description: A lazy-loading component for Blade views. This should be used
with the `LazyLoading` trait in Livewire components.
 --}}

@props(['prop', 'component' => null])

@php
  $ready = "ready_to_load_{$prop}";
@endphp

@unless ($component)
  <section {{ $attributes }} wire:init='$set("{{ $ready }}", true)'>
    @unless ($this->{$ready})
      <span style="margin-block: 5em;" class="loader"></span>
    @else
      {{ $slot }}
    @endunless
  </section>
@else
  <x-dynamic-component :component="$component" {{ $attributes }} wire:init='load("{{ $prop }}")'>
    @unless ($this->{$ready})
      <span style="margin-block: 5em;" class="loader"></span>
    @else
      {{ $slot }}
    @endunless
  </x-dynamic-component>
@endunless
