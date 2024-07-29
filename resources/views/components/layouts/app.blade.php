{{--
file: resources/views/components/layouts/app.blade.php
author: Ian Kollipara
date: 2024-07-26
description: The layout for the application
 --}}

@props(['title'])

<!DOCTYPE html>
<html class="tw-h-full"
      lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
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
  {{ $slot }}
  <div class="tw-fixed tw-top-0 tw-right-0 tw-z-[1000] tw-m-8 tw-max-w-full"
       id="toast_container">
    @session('success')
      <div class="notification is-success animate__animated animate__fadeIn"
           x-data>
        <div class="is-flex is-justify-content-between is-align-items-start">
          <p class="has-text-white mr-2">{{ session('success') }}</p>
          <button class="delete"
                  type="button"
                  x-on:click="
            $root.classList.remove('animate__fadeIn');
            $root.classList.add('animate__fadeOut');
            setTimeout(() => $root.remove(), 1000);
            "></button>
        </div>
      </div>
    @endsession
    @session('error')
      <div class="notification is-danger animate__animated animate__fadeIn"
           x-data>
        <div class="is-flex is-justify-content-between is-align-items-start">
          <p class="has-text-white mr-2">{{ session('error') }}</p>
          <button class="delete"
                  type="button"
                  x-on:click="
            $root.classList.remove('animate__fadeIn');
            $root.classList.add('animate__fadeOut');
            setTimeout(() => $root.remove(), 1000);
            "></button>
        </div>
      </div>
    @endsession
  </div>
</body>

</html>
