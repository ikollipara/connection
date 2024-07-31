{{--
file: resources/views/form/submit.blade.php
author: Ian Kollipara
date: 2024-07-26
description: The HTML for the submit form component
 --}}

@props(['label'])

@aware(['formName'])

<button form="{{ $formName }}"
        type="submit"
        {{ $attributes->class(['button']) }}>
  {{ $label ?? $slot }}
</button>
