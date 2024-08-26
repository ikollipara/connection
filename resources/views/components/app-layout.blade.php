{{--
file: resources/views/components/app-layout.blade.php
author: Ian Kollipara
date: 2024-07-31
description: |
    The layout for the application. This component provides a consistent
    layout for all pages in the application, including a header, footer,
    and main content area. It also includes a responsive navigation menu
    that can be toggled on mobile devices.

    In addition the layout includes stacks for:
      - Notifications
      - Modals
      - Scripts
      - Styles
      - Meta tags
 --}}

@props(['title', 'htmlClass' => [], 'header' => null, 'footer' => null, 'nav' => null])

@php
  $htmlClass = is_array($htmlClass) ? $htmlClass : explode(' ', $htmlClass);
@endphp

<!DOCTYPE html>
<html lang="en"
      @class($htmlClass)>

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
  <meta name="robots"
        content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large">
  @stack('meta')
  <link href="{{ mix('css/app.css') }}"
        rel="stylesheet">
  <x-style href="{{ mix('css/animate.css') }}" />
  <x-style href="{{ mix('css/slim-select.css') }}" />
  @stack('styles')
  <script defer
          src="{{ mix('js/app.js') }}"></script>
  @stack('scripts')
  <title>{{ $title }}</title>
</head>

<body {{ $attributes }}>
  @if ($nav)
    {{ $nav }}
  @endif
  @if ($header)
    {{ $header }}
  @endif
  {{ $slot }}
  @if ($footer)
    {{ $footer }}
  @endif
  <div class="notification-container">
    @stack('notifications')
    @session('success')
      <x-notification type="success"
                      :message="session('success')" />
    @endsession
    @session('error')
      <x-notification type="danger"
                      :message="session('error')" />
    @endsession
  </div>
</body>

</html>
