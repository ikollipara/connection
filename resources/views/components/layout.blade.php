@props(['title' => 'ConneCTION'])

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="Connect with teachers all over about Computer Science. Learn from their experiences, share your own. This is a community to helpYou grow!">
  <meta name="robots" content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large">
  <meta name="og:title" content="{{ $title }}">
  <meta name="og:description"
    content="Connect with teachers all over about Computer Science. Learn from their experiences, share your own. This is a community to helpYou grow!">
  <meta name="og:site_name" content="conneCTION">
  <meta name="og:image" content="/favicon-32x32.png">
  <meta name="subject" content="Computer Science Education">
  <meta name="author" content="Ian Kollipara, ikollipara@huskers.unl.edu">
  <meta name="url" content="{{ url()->current() }}">
  <meta name="keywords"
    content="computer, science, education, cs, ed, resources, air@ne, unl, csta, nebraska, connection">
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
