@props(['title' => 'ConneCTION'])

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @stack('meta')
  @routes
  @livewireStyles
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <script defer src="{{ mix('js/app.js') }}"></script>
  @livewireScripts
  @stack('styles')
  @stack('scripts')
  <title>{{ $title }}</title>
</head>

<body>
  <x-navbar />
  {{ $slot }}
</body>

</html>
