{{--
file: resources/views/components/hero.blade.php
author: Ian Kollipara
date: 2024-06-13
description: This file contains the HTML for a hero section.
 --}}

@props(['heroBodyClass' => []])

@php
  $heroBodyClass = is_array($heroBodyClass) ? $heroBodyClass : explode(' ', $heroBodyClass);
@endphp

<section {{ $attributes->class(['hero']) }}>
  <div @class(['hero-body', ...$heroBodyClass])>
    {{ $slot }}
  </div>
</section>
