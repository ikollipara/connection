
@php
    $avatar = $event->user ? $event->user->avatar : 'https://ui-avatars.com/api/?name=Deleted&color=7F9CF5&background=EBF4FF';
    $full_name = $event->user ? $event->user->full_name : 'Deleted';
    $description = Js::from(old('description')) ?? $event->description;
    $description = is_string($description) ? $description : json_encode($description);
    $attendee = $event->getAttendeeFor(auth()->user());
    $route = $attendee ? route('events.attendee.destroy', [$attendee]) : route('events.attendee.store', $event);
    dump($attendee);
@endphp
<x-layout no-livewire>
  <x-hero class="is-primary"
          hero-body-class="has-text-centered">
    <h1 class="title is-1">{{ $event->title }}</h1>

    </div>
    <div class="level bordered">
        <div class="level-left">
            <p class="level-item is-primary ml-5">
                When: {{ $event->start_date->formatLocalized('%B %d') }}
            @if (!is_null($event->end_date))
                to {{ $event->end_date->formatLocalized('%B %d') }}
            @endif
            </p>
            <p class="level-item ml-5">
                Where: {{$event->location}}
            </p>    
        </div>
        <div class="level-left has-text-centered">
            <p>Created by: </p>
            <figure class="image is-32x32"><img src="{{ $avatar }}"
                alt=""></figure>
            <a class="link is-italic"
                @if ($event->user) href="{{ route('users.show', $event->user) }}" @endif>
                {{ $full_name }}
            </a>
        </div>
        <div class="level-right">
        <form action="{{ $route }}" method="post">
            @csrf
            @if ($attendee)
                @method('DELETE')
            @else
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <input type="hidden" name="event_id" value="{{ $event->id }}">
            @endif
            <button type="submit" @class([
                'button',
                'mx-5',
                'is-success' => !$attendee,
                'is-danger' => $attendee,
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
              value="{!! $event->description !!}"/>
  </x-container>
</x-layout>
