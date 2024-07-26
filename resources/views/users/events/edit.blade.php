@php
  $title = "conneCTION - Edit {$event->title}";
  $description = old('description') ?? $event->description;
  $description = is_string($description) ? $description : json_encode($description);
@endphp



<x-layout :title="$title" no-livewire>
  <x-hero x-data="{}" class="is-primary" hero-body-class="level">
    <x-help title="Event Editor">
      <p class="content has-text-black">
        This is the event editor! Here you can write your event and publish it to the world.
        The metadata accessed via the 'publish' or 'update metadata' button let's you set
        certain attributes about the event that make it easier for people to find. Lastly,
        there is no autosave, so consider saving frequently.
      </p>
    </x-help>
    <x-unsaved-indicator />
    <x-forms.input has-addons without-label form="edit-event-form" name="title" placeholder="Event Title..."
      x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor:unsaved')"
      value="{{ $event->title }}" field-classes="is-flex-grow-1">
      <div class="control">
        <button type="submit" form="edit-event-form" class="button is-dark">Save</button>
      </div>
      <div class="control">
        <x-modal title="Set Metadata" btn="Metadata">
          <x-metadata.form id="edit-event-form" method="PATCH" action="{{ route('users.events.update', ['me', $event]) }}"
            :metadata="$event->metadata->toArray()" />
          <x-slot name="footer">
            <button x-on:click="show = false" form="edit-event-form" type="submit"
              class="button is-primary preserve-rounding">
              Update
            </button>
          </x-slot>
        </x-modal>
      </div>
      <div class="control">
        <input id="event-publish" type="hidden" name="published" form="edit-event-form"
          value="{{ $event->published ? '1' : '0' }}">
        @unless ($event->published)
          <button type="submit" form="edit-event-form" x-on:click="document.getElementById('event-publish').value = '1'"
            class="button is-link">Publish</button>
        @endunless
      </div>
      <div class="control">
        <x-modal title="Cancel Event" btn-class="is-danger has-text-white" btn="{{ $event->trashed() ? 'Restore' : 'Cancel' }}">
            <form id="cancel-event-form" method="post" action="{{ route('users.events.destroy', ['me', $event]) }}">
                @csrf
                @method('DELETE')
                <p class="content has-text-black">
                    Are you sure you want to cancel <strong>{{ $event->title }}?</strong> This action will remove the event from all calendars and alert all attendees.
                </p>
            </form>
            <x-slot name="footer">
            <button type="submit" form="cancel-event-form" class="button is-danger has-text-white preserve-rounding">
                Cancel Event
          </button>
            </x-slot>
        </x-modal>
      </div>
    </x-forms.input>
    </x-hero>
    <x-container is-fluid class="mt-5 columns mx-5">
        <div x-data="{has_end_date: {{ Js::from((bool) old('end_date')) }}, is_all_day: {{ Js::from(old('is_all_day', true)) }} }" class="column is-one-quarter">
            <h2 class="subtitle is-3">Date and Time</h2>
            <x-forms.input 
                label="Start Date"  
                name="start_date" 
                type="date" 
                form="edit-event-form" 
                value="{{$event->start_date->toDateString()}}"
                min="{{ old('start_date', today()->toDateString()) }}" 
                required />
              <x-forms.input 
                label="Location"  
                name="location" 
                type="string" 
                form="edit-event-form" 
                value="{{$event->location}}"/>
            <label class="checkbox">
                <input 
                x-model="has_end_date" 
                type="checkbox">
                Multiple day event
            </label>
            <template x-if="has_end_date">
               <span>
                    <x-forms.input 
                        label="End Date" 
                        name="end_date" 
                        type="date" 
                        value="{{$event->end_date->toDateString()}}"
                        form="edit-event-form" />
                    <input type="checkbox" hidden name="is_all_day" checked form="edit-event-form">
                </span>
            </template>
            <label class="checkbox">
                <input x-model="is_all_day" x-bind:disabled="has_end_date" type="checkbox" name="is_all_day" form="edit-event-form" x-bind:checked="is_all_day || has_end_date">
                All Day Event
            </label>
            <template x-if="!is_all_day">
            <span>
                <x-forms.input 
                    label="Start Time" 
                    name="start_time"
                    type="time" 
                    value="{{$event->start_time}}"
                    form="edit-event-form" />
                <x-forms.input 
                    label="End Time" 
                    name="end_time" 
                    type="time" 
                    value="{{$event->end_time}}"
                    form="edit-event-form" />
            </span>
            </template>
        </div>
        <div class="column">
        <x-editor form="edit-event-form" name="description" value="{!! $description !!}" />
        </div>
    </x-container>
</x-layout>
