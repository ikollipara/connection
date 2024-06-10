@props(['title' => 'ConneCTION', 'noLivewire' => false])

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @stack('meta')
  @routes
  @unless ($noLivewire)
    @livewireStyles
  @endunless
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <script defer src="{{ mix('js/app.js') }}"></script>
  @unless ($noLivewire)
    @livewireScripts
  @endunless
  @stack('styles')
  @stack('scripts')
  <title>{{ $title }}</title>
</head>

<body {{ $attributes }}>
  <x-navbar />
  {{ $slot }}
</body>

</html>
