{{--
file: resources/views/components/form-help-text.blade.php
author: Ian Kollipara
date: 2024-09-21
description: This file contains the HTML for a form help text component.
 --}}

<p {{ $attributes->class(['mt-2 text-sm text-gray-500 dark:text-gray-400']) }}>
  {{ $message ?? $slot }}
</p>
