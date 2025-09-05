{{--
file: resources/views/components/app-layout.blade.php
author: Ian Kollipara
date: 2024-09-08
description: The primary layout for the application.
--}}

@props(['title' => ''])

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
  @stack('meta')
  @routes
  @vite(['resources/css/app.css', 'resources/css/slim-select.css', 'resources/js/app.ts'])
  @stack('styles')
  @stack('scripts')
  <title>{{ config('app.name') . (filled($title) ? ' - ' . $title : '') }}</title>
</head>

<body {{ $attributes }}>
  {{ $slot }}
  @stack('modals')
</body>

</html>
