@props(['title'])
<article>
  <h2 class="subtitle">{{ $title }}</h2>
  {{ $slot }}
  <p>
    ConneCTION is a platform for teachers to share, comment, and collect materials to aid in teaching Computer
    Science.
    ConneCTION is focused on building an online learning community around Computer Science education. So to use
    ConneCTION,
    you only need to <a class="link"
       href="{{ route('search') }}">search</a> for the materials you need, and if you
    have any
    materials to share, you can create a <a class="link"
       href="{{ route('posts.create') }}">post</a> or a <a class="link"
       href="{{ route('collections.create') }}">collection</a>.
  </p>
</article>
