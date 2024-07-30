@php
  $title = 'conneCTION - Create Event';
  $description = old('description') ?? '{"blocks": []}';
@endphp

<x-layout :title="$title"
          no-livewire>
  <x-hero class="is-primary"
          x-data="{}"
          hero-body-class="level">
    <x-help title="Event Editor">
      <p class="content has-text-black">
        Create an event! Make a title, select a date, and write a short description for your event.
      </p>
    </x-help>
    <x-unsaved-indicator />
    <x-forms.input name="title"
                   form="create-event-form"
                   has-addons
                   without-label
                   placeholder="Event Title..."
                   x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor:unsaved')"
                   field-classes="is-flex-grow-1">

      <div class="control">
        <button class="button is-dark"
                type="button"
                x-on:click="document.querySelector('.drawer').classList.add('open')">Edit Details</button>
      </div>
      <div class="control">
        <button class="button"
                form="create-event-form"
                type="submit">Save</button>
      </div>
    </x-forms.input>
  </x-hero>
  <x-container class="mt-5 columns mx-5"
               is-fluid>

    <div class="column">
      <x-editor name="description"
                form="create-event-form"
                value="{!! $description !!}" />
    </div>
    <div class="drawer"
         x-data>
      <div class="drawer-background"
           x-on:click="$root.classList.remove('open')"></div>
      <div class="drawer-content"
           x-data="{ start_date: null, is_all_day: {{ Js::from(old('is_all_day', true)) }} }">
        <h2 class="subtitle is-3">Details</h2>
        <x-forms.input name="start_date"
                       form="create-event-form"
                       type="date"
                       x-model="start_date"
                       label="Start Date"
                       min="{{ today()->toDateString() }}"
                       required />
        <x-forms.input name="end_date"
                       form="create-event-form"
                       type="date"
                       label="End Date (optional)"
                       x-bind:min="start_date"
                       min="start_date" />
        <x-forms.input name="location"
                       form="create-event-form"
                       type="string"
                       label="Location (optional)" />
        <input name="is_all_day"
               form="create-event-form"
               type="checkbox"
               hidden
               checked>
        <label class="checkbox">
          <input name="is_all_day"
                 form="create-event-form"
                 type="checkbox"
                 x-model="is_all_day">
          All Day
        </label>
        <template x-if="!is_all_day">
          <span>
            <x-forms.input name="start_time"
                           form="create-event-form"
                           type="time"
                           label="Start Time" />
            <x-forms.input name="end_time"
                           form="create-event-form"
                           type="time"
                           label="End Time" />
          </span>
        </template>
        <div class="buttons mt-2">
          <x-modal title="Set Metadata"
                   btn="Metadata">
            <x-metadata.form id="create-event-form"
                             method="post"
                             action="{{ route('users.events.store', 'me') }}" />
            <x-slot name="footer">
              <button class="button is-primary preserve-rounding"
                      form="create-event-form"
                      type="submit"
                      x-on:click="show = false">
                Update
              </button>
            </x-slot>
          </x-modal>
          <button class="button is-dark"
                  form="create-event-form"
                  type="submit">Save</button>
        </div>

      </div>
    </div>
  </x-container>
</x-layout>
