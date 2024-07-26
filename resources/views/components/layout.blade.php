@props(['title' => 'ConneCTION'])

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
  <meta name="description"
        content="Connect with teachers all over about Computer Science. Learn from their experiences, share your own. This is a community to helpYou grow!">
  <meta name="robots"
        content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large">
  <meta name="og:title"
        content="{{ $title }}">
  <meta name="og:description"
        content="Connect with teachers all over about Computer Science. Learn from their experiences, share your own. This is a community to helpYou grow!">
  <meta name="og:site_name"
        content="conneCTION">
  <meta name="og:image"
        content="/favicon-32x32.png">
  <meta name="subject"
        content="Computer Science Education">
  <meta name="author"
        content="Ian Kollipara, ikollipara@huskers.unl.edu">
  <meta name="url"
        content="{{ url()->current() }}">
  <meta name="keywords"
        content="computer, science, education, cs, ed, resources, air@ne, unl, csta, nebraska, connection">
  @stack('meta')
  @routes
  <link href="{{ mix('css/app.css') }}"
        rel="stylesheet">
  <x-style href="{{ mix('css/animate.css') }}" />
  <x-style href="{{ mix('css/slim-select.css') }}" />
  <script defer
          src="{{ mix('js/app.js') }}"></script>
  @stack('styles')
  @stack('scripts')
  <title>{{ $title }}</title>
</head>

<body {{ $attributes }}>
  <x-navbar />
  {{ $slot }}
  <div id="toast_container"
       style="position:fixed; top: 0; right: 0; z-index: 1000; margin: 2rem; max-width: 100%;">
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
