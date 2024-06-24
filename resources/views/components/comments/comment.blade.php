{{--
file: resources/views/components/comments/comment.blade.php
author: Ian Kollipara
date: 2024-06-24
description: Comment component for displaying a comment
 --}}

@props(['comment', 'buttons' => null, 'mediaClass' => [], 'contentClass' => [], 'figureClass' => []])

@php
  $full_name = $comment->user ? $comment->user->full_name : '[Deleted]';
  $mediaClass = is_array($mediaClass) ? $mediaClass : explode(' ', $mediaClass);
  $contentClass = is_array($contentClass) ? $contentClass : explode(' ', $contentClass);
  $figureClass = is_array($figureClass) ? $figureClass : explode(' ', $figureClass);
@endphp

<article @class(['media', ...$mediaClass])>
  <figure @class(['media-left', ...$figureClass])>
    <p class="image is-64x64">
      <img src="{{ $comment->user->avatar }}" alt="{{ $full_name }}">
    </p>
  </figure>
  <section @class(['media-content', ...$contentClass])>
    <p class="content">
      <strong>{{ $full_name }}</strong>
      <br>
      {{ $comment->body }}
    </p>
    @if ($buttons)
      <div {{ $buttons->attributes->class(['buttons']) }}>
        {{ $buttons }}
      </div>
    @endif
  </section>
</article>
