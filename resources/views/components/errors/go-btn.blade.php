{{--
file: /resources/views/components/errors/go-btn.blade.php
author: Ian Kollipara
date: 2024-06-10
description: This file contains the HTML for the go home button component.
 --}}

@props(['text' => __('Go Home'), 'route' => route('home')])

<a class="button is-primary icon-text has-text-light"
   href="{{ $route }}">
  <span class="icon">
    <x-lucide-chevron-left width="50"
                           height="50" />
  </span>
  <span>{{ $text }}</span>
</a>
