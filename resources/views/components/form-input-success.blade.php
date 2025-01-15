{{--
file: resources/views/components/form-input-success.blade.php
author: Ian Kollipara
date: 2024-09-08
description: The HTML for the input form component with success messages
 --}}

@props(['value', 'message' => null])

@session('success')
  <p class="mt-2 text-sm text-green-600 dark:text-green-500">
    <span class="font-medium">All Good!</span> {{ session('success', $message ?? $slot) }}
  </p>
@endsession
