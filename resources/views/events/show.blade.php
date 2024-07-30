@php
  $avatar = $event->user ? $event->user->avatar : 'https://ui-avatars.com/api/?name=Deleted&color=7F9CF5&background=EBF4FF';
  $full_name = $event->user ? $event->user->full_name : 'Deleted';
  $description = Js::from(old('description')) ?? $event->description;
  $description = is_string($description) ? $description : json_encode($description);
  $attendee = $event->getAttendeeFor(auth()->user());
  $route = $attendee ? route('events.attendee.destroy', [$attendee]) : route('events.attendee.store', $event);
@endphp
<x-layout no-livewire>
  <x-hero class="is-primary"
          hero-body-class="has-text-centered">
    <h1 class="title is-1">{{ $event->title }}</h1>
    <div class="column tw-flex tw-flex-col tw-items-center tw-justify-center">
      <p>Created by: </p>
      <figure class="image tw-size-16">
        <img src="{{ $avatar }}"
             alt="">
      </figure>
      <a class="link is-italic"
         @if ($event->user) href="{{ route('users.show', $event->user) }}" @endif>
        {{ $full_name }}
      </a>
    </div>
    <div class="level bordered">
      <div class="level-left">
        <p class="level-item is-primary ml-5">
          When: {{ $event->start->formatLocalized('%B %d, %H:%m %p') }}
          @if (!is_null($event->end_date))
            to {{ $event->end->formatLocalized('%B %d, %H:%m %p') }}
          @endif
        </p>
        <p class="level-item ml-5">
          Where: {{ $event->location }}
        </p>
      </div>
      <div class="level-right">
        <form action="{{ $route }}"
              method="post">
          @csrf
          @if ($attendee)
            @method('DELETE')
          @else
            <input name="user_id"
                   type="hidden"
                   value="{{ auth()->id() }}">
            <input name="event_id"
                   type="hidden"
                   value="{{ $event->id }}">
          @endif
          <button type="submit"
                  @class([
                      'button',
                      'mx-5',
                      'is-primary' => !$attendee,
                      'is-outlined' => $attendee,
                  ])>
            <x-bulma-icon icon="{{ $attendee ? 'lucide-user-minus' : 'lucide-user-plus' }}">
              {{ $attendee ? 'Unattend' : 'Attend' }}
            </x-bulma-icon>
          </button>
        </form>
      </div>
    </div>
  </x-hero>
  <x-container class="mt-5"
               is-fluid>
    <details class="is-clickable">
      <summary>Metadata</summary>
      <x-metadata.table :metadata="$event->metadata" />
    </details>
    <x-editor name="editor"
              value="{!! $event->description !!}"
              read-only />
  </x-container>
</x-layout>
