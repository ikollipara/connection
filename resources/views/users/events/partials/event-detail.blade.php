{{--
file: resources/views/users/events/partials/event-detail.blade.php
author: Ian Kollipara
date: 2024-09-08
description: The view for the event detail partials.
 --}}

<article>
  <div class="media-content">
    <div class="content">
      <p>
        <strong>{{ $event->title }}</strong> <small>{{ $event->location }}</small>
        <small>{{ $event->days_count }}</small>
        <br>
        {{ $event->description }}
      </p>
    </div>
    <nav class="level is-mobile">
      <div class="level-left">
        <a class="level-item"
           href="{{ route('users.events.edit', ['me', $event]) }}">
          Edit
        </a>
        <a class="level-item"
           href="{{ route('users.events.edit', ['me', $event]) }}">
          Delete
        </a>
      </div>
    </nav>
  </div>
</article>
