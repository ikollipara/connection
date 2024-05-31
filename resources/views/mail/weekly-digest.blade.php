@php
  $user_or_default = function ($user) {
      return $user ? $user->full_name() : '[Deleted]';
  };
@endphp

@component('mail::message')
  # {{ $week }} Weekly Digest

  @if ($extra)
    {!! $extra !!}

    ---
  @endif

  ## Post of the Week
  ### {{ $postOfTheWeek[0]->title }} by {{ $user_or_default($postOfTheWeek[0]->user) }}

  {!! $postOfTheWeek[1] !!}
  @component('mail::button', ['url' => route('posts.show', $postOfTheWeek[0])])
    Read More
  @endcomponent

  ---

  ## Random Post of the Week
  ### {{ $randomPostOfTheWeek->title }} by {{ $user_or_default($randomPostOfTheWeek->user) }}

  @component('mail::button', ['url' => route('posts.show', $randomPostOfTheWeek)])
    Read More
  @endcomponent

  ---

  ## Top 5 New Posts of the Week
  @component('mail::table')
    | Title | Author | Views | Likes | Comments |
    |-------|--------|-------|-------|----------|
    @foreach ($topPostsOfTheWeek as $post)
      | [{{ $post->title }}]({{ route('posts.show', $post) }}) | {{ $user_or_default($post->user) }} | {{ $post->views }}
      |
      {{ $post->likes_count }} | {{ $post->comments_count }} |
    @endforeach
  @endcomponent

  ---

  ## Top 5 New Collections of the Week
  @component('mail::table')
    | Title | Author | Views | Likes | Comments |
    |-------|--------|-------|-------|----------|
    @foreach ($topCollectionsOfTheWeek as $collection)
      | [{{ $collection->title }}]({{ route('posts.show', $collection) }}) | {{ $user_or_default($collection->user) }} |
      {{ $collection->views }} |
      {{ $collection->likes_count }} | {{ $collection->comments_count }} |
    @endforeach
  @endcomponent

  ---
  Thanks,<br>
  Ian Kollipara - Primary Developer of {{ config('app.name') }}
  [{{ config('app.name') }}]({{ config('app.url') }})
  [Unsubscribe]({{ $unsubscribeLink }})
@endcomponent
