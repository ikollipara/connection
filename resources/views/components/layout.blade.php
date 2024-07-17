@props(['title' => 'ConneCTION'])

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @stack('meta')
  @routes
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <x-style href="{{ mix('css/animate.css') }}" />
  <x-style href="{{ mix('css/slim-select.css') }}" />
  <script defer src="{{ mix('js/app.js') }}"></script>
  @stack('styles')
  @stack('scripts')
  <title>{{ $title }}</title>
</head>

<body {{ $attributes }}>
  <x-navbar />
  {{ $slot }}
</body>

</html>
