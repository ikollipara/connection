{{--
file: resources/views/components/style.blade.php
author: Ian Kollipara
date: 2024-07-17
description: This file contains a component for lazy loading stylesheets.
  --}}

@props(['href'])

<link href="{{ $href }}"
      rel="preload"
      as="style"
      onload="this.onload=null;this.rel='stylesheet'">
<noscript>
  <link href="{{ $href }}"
        rel="stylesheet">
</noscript>
