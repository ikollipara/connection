{{--
file: resources/views/components/form-input-error.blade.php
author: Ian Kollipara
date: 2024-09-08
description: The HTML for the input form component with error messages
 --}}

@props(['name', 'message' => null])

@error($name)
  <p class="mt-2 text-sm text-red-600 dark:text-red-500">
    <span class="font-medium">Uh Oh.</span> {{ $message ?? $slot }}
  </p>
@enderror
