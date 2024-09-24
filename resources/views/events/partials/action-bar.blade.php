{{--
file: resources/views/events/partials/action-bar.blade.php
author: Ian Kollipara
date: 2024-09-23
description: The action bar for an event
 --}}

<ul class="flex flex-wrap items-center justify-start text-gray-900 dark:text-white">
  <li>
    <x-form form-name="like"
            x-data
            x-on:submit.prevent="
            fetch($el.action, {
                method: $el.method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $refs.csrf.value
                },
                body: JSON.stringify({
                    model_type: $refs.model_type.value,
                    model_id: $refs.model_id.value,
                }),
            }).then(response => {
                if (response.ok) {
                    response.json().then(data => {
                        $refs.like_button.textContent = data.likes === 1 ? (data.likes + ' Like') : (data.likes + ' Likes');
                    });
                } else {
                    response.json().then(data => {
                        alert(data.message);
                    });
                }
            })
            "
            action="{{ route('api.like') }}"
            method="post">
      <input name="model_type"
             type="hidden"
             value="{{ $event::class }}"
             x-ref="model_type">
      <input name="model_id"
             type="hidden"
             value="{{ $event->id }}"
             x-ref="model_id">
      <button class="me-4 hover:underline md:me-6"
              type="submit"
              x-ref="like_button">{{ $event->likes() }} {{ Str::plural('Like', $event->likes()) }}</button>
    </x-form>
  </li>
  <li>
    <p class="me-4  md:me-6 ">{{ $event->views() }} Views</p>
  </li>
  @auth
    @if ($event->attendedBy(auth()->user()))
      <x-form form-name="unattend-event"
              action="{{ route('events.attendees.destroy', [$event, auth()->id()]) }}"
              method="delete">
        <button class="me-4 hover:underline md:me-6"
                type="submit">Unattend</button>
      </x-form>
    @else
      <x-form form-name="attend-event"
              action="{{ route('events.attendees.store', $event) }}"
              method="post">
        <input name="user_id"
               type="hidden"
               value="{{ auth()->id() }}">
        <button class="me-4 hover:underline md:me-6"
                type="submit">Attend</button>
      </x-form>
    @endif
  @endauth
  {{-- <li>
    <a class="me-4 hover:underline md:me-6"
       href="{{ route('events.comments.index', $event) }}">See Comments</a>
  </li> --}}
  <li>
    <a class="me-4 hover:underline md:me-6"
       href="{{ route('users.profile.show', $event->user) }}">View Author</a>
  </li>
</ul>
