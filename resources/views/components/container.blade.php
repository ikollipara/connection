{{--
file: resources/views/components/container.blade.php
author: Ian Kollipara
date: 2024-05-28
description: A wrapper component for the Bulma container class.
 --}}

@props(['isFluid' => false])

<main {{ $attributes->class(['container', 'is-fluid' => $isFluid]) }}>
  {{ $slot }}
</main>
