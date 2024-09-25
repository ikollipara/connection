{{--
file: resources/views/search/partials/results.blade.php
author: Ian Kollipara
date: 2024-09-23
description: The search results for the search form
 --}}

<div class="mt-3 space-y-3">
  @forelse ($results as $result)
    @if ($result instanceof App\Models\Post)
      @include('search.partials.content-result', [
          'content' => $result,
          'href' => route('posts.show', $result),
      ])
    @elseif ($result instanceof App\Models\ContentCollection)
      @include('search.partials.content-result', [
          'content' => $result,
          'href' => route('collections.show', $result),
      ])
    @elseif ($result instanceof App\Models\Event)
      @include('search.partials.event-result', ['event' => $result])
    @endif
  @empty
    @if (request()->has('q'))
      <p>No Results Found for "{{ request('q') }}".</p>
    @endif
  @endforelse
</div>
