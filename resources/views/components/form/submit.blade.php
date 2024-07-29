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
        {{ $attributes->class(['tw-bg-primary-950 tw-text-cn-white-50 tw-p-2 tw-rounded', 'hover:tw-bg-gray-950', 'focus:tw-scale-95', 'tw-transition-all']) }}>
  {{ $label }}
</button>
