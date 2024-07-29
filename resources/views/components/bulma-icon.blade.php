{{--
file: resources/views/components/icon.blade.php
author: Ian Kollipara
date: 2024-06-17
description: The HTML for an icon
 --}}

@props(['icon', 'width' => 30, 'height' => 30, 'noText' => false])

@php
  $name = $icon;
@endphp

<span class="icon-text">
  <span class="icon">
    <x-icon :name="$icon"
            :width="$width"
            :height="$height"
            {{ $attributes }} />
  </span>
  @unless ($noText)
    <span>{{ $slot }}</span>
  @endunless
</span>
