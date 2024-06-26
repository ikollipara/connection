{{--
file: resources/views/components/icons/square-x.blade.php
author: Ian Kollipara
date: 2024-06-17
description: The HTML for a square x icon. Sourced from lucide-icons.
 --}}

<svg xmlns="http://www.w3.org/2000/svg"viewBox="0 0 24 24"
  {{ $attributes->merge(['width' => 30, 'height' => 30, 'fill' => 'none']) }} stroke="currentColor" stroke-width="2"
  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-x">
  <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
  <path d="m15 9-6 6" />
  <path d="m9 9 6 6" />
</svg>
