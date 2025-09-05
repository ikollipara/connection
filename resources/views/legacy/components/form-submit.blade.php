{{--
file: resources/views/components/form-submit.blade.php
author: Ian Kollipara
date: 2024-09-08
description: The HTML for the submit form component
 --}}

@props(['label' => null])

<button x-data
        {{ $attributes->class(['text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800'])->merge(['type' => 'submit']) }}>
  {{ $label ?? $slot }}
</button>
