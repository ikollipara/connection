@php
  $title = 'conneCTION - Create Event';
  $description = old('description') ?? '{"blocks": []}';
@endphp

<x-layout :title="$title" no-livewire>
  <x-hero x-data="{}" class="is-primary" hero-body-class="level">
    <x-help title="Event Editor">
      <p class="content has-text-black">
        Create an event! Make a title, select a date, and write a short description for your event.
      </p>
    </x-help>
    <x-unsaved-indicator />
    <x-forms.input has-addons without-label form="create-event-form" name="title" placeholder="Event Title..."
      x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor:unsaved')"
      field-classes="is-flex-grow-1">
      
      <div class="control">
        <input id="event-publish" type="hidden" name="published" form="create-event-form" value="0">
        <button type="submit" form="create-event-form"
          x-on:click="document.getElementById('event-publish').value = '1'" class="button is-link">Publish</button>
      </div>
    </x-forms.input>
  </x-hero>
  <x-container is-fluid class="mt-5 columns mx-5">
    
    <div class="column">
      <x-editor form="create-event-form" name="description" value="{!! $description !!}" />
    </div>
    <div x-data="{ start_date: null, is_all_day: {{ Js::from(old('is_all_day', true)) }} }" class="column is-one-quarter">
      <h2 class="subtitle is-3">Details</h2>
      <x-forms.input x-model="start_date" label="Start Date" name="start_date" type="date" form="create-event-form" min="{{ today()->toDateString() }}" required />
      <x-forms.input label="End Date (optional)" name="end_date" x-bind:min="start_date" type="date" form="create-event-form" min="start_date"/>
      <x-forms.input label="Location (optional)" name="location" type="string" form="create-event-form"/>
        <input type="checkbox" hidden name="is_all_day" checked form="create-event-form">
      <label class="checkbox">
        <input x-model="is_all_day" type="checkbox" name="is_all_day" form="create-event-form">
        All Day
      </label>
      <template x-if="!is_all_day">
        <span>
            <x-forms.input label="Start Time" name="start_time" type="time" form="create-event-form" />
            <x-forms.input label="End Time" name="end_time" type="time" form="create-event-form" />
        </span>
      </template>
        <div class="control mt-2">
          <x-modal title="Set Metadata" btn="Metadata">
            <x-metadata.form id="create-event-form" method="post" action="{{ route('users.events.store', 'me') }}"/>
            <x-slot name="footer">
              <button x-on:click="show = false" form="create-event-form" type="submit"
                class="button is-primary preserve-rounding">
                Update
              </button>
            </x-slot>
          </x-modal>
          <button type="submit" form="create-event-form" class="button is-dark mx-5">Save</button>
        </div>

    </div>
  </x-container>
</x-layout>
