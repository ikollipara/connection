{{--
file: resources/views/components/title.blade.php
author: Ian Kollipara
date: 2024-09-09
description: The title component for the application
 --}}

@props(['label' => null])

<h1
    {{ $attributes->class(['mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white']) }}>
  {{ $label ?? $slot }}
</h1>
