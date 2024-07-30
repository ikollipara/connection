@php
  $title = "conneCTION - Edit {$event->title}";
  $description = old('description') ?? $event->description;
  $description = is_string($description) ? $description : json_encode($description);
@endphp

<x-layout :title="$title"
          no-livewire>
  <x-hero class="is-primary"
          x-data="{}"
          hero-body-class="level">
    <x-help title="Event Editor">
      <p class="content has-text-black">
        This is the event editor! Here you can write your event and publish it to the world.
        The metadata accessed via the 'publish' or 'update metadata' button let's you set
        certain attributes about the event that make it easier for people to find. Lastly,
        there is no autosave, so consider saving frequently.
      </p>
    </x-help>
    <x-unsaved-indicator />
    <x-forms.input name="title"
                   form="edit-event-form"
                   value="{{ $event->title }}"
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
                form="edit-event-form"
                type="submit"
                x-data
                x-on:click="if(!document.querySelector('[name=start_date]').value) { document.querySelector('.drawer').classList.add('open') }">Save</button>
      </div>
      <div class="control">
        <x-modal title="Cancel Event"
                 btn-class="is-danger has-text-white"
                 btn="{{ $event->trashed() ? 'Restore' : 'Cancel' }}">
          <form id="cancel-event-form"
                method="post"
                action="{{ route('users.events.destroy', ['me', $event]) }}">
            @csrf
            @method('DELETE')
            <p class="content has-text-black">
              Are you sure you want to cancel <strong>{{ $event->title }}?</strong> This action will remove the event
              from all calendars and alert all attendees.
            </p>
          </form>
          <x-slot name="footer">
            <button class="button is-danger has-text-white preserve-rounding"
                    form="cancel-event-form"
                    type="submit">
              Cancel Event
            </button>
          </x-slot>
        </x-modal>
      </div>
    </x-forms.input>
  </x-hero>
  <x-container class="mt-5 columns mx-5"
               is-fluid>
    <div class="column">
      <x-editor name="description"
                form="edit-event-form"
                value="{!! $description !!}" />
    </div>
    <div class="drawer"
         x-data>
      <div class="drawer-background"
           x-on:click="$root.classList.remove('open')"></div>
      <div class="drawer-content"
           x-data="{ start_date: '{{ $event->start_date->toDateString() }}', is_all_day: {{ Js::from(old('is_all_day', $event->is_all_day)) }} }">
        <h2 class="subtitle is-3">Details</h2>
        <x-forms.input name="start_date"
                       form="edit-event-form"
                       type="date"
                       x-model="start_date"
                       label="Start Date"
                       min="{{ $event->start_date->toDateString() }}"
                       required />
        <x-forms.input name="end_date"
                       form="edit-event-form"
                       type="date"
                       value="{{ $event->end_date ? $event->end_date->toDateString() : '' }}"
                       label="End Date (optional)"
                       x-bind:min="start_date" />
        <x-forms.input name="location"
                       form="edit-event-form"
                       type="string"
                       value="{{ $event->location }}"
                       label="Location (optional)" />
        <label class="checkbox">
          <input name="is_all_day"
                 form="edit-event-form"
                 type="checkbox"
                 x-model="is_all_day">
          All Day
        </label>
        <template x-if="!is_all_day">
          <span>
            <x-forms.input name="start_time"
                           form="edit-event-form"
                           type="time"
                           value="{{ $event->start_time->toTimeString() }}"
                           label="Start Time" />
            <x-forms.input name="end_time"
                           form="edit-event-form"
                           type="time"
                           value="{{ $event->end_time->toTimeString() }}"
                           label="End Time" />
          </span>
        </template>
        <div class="buttons mt-2">
          <x-modal title="Set Metadata"
                   btn="Metadata">
            <x-metadata.form id="edit-event-form"
                             method="PATCH"
                             :metadata="$event->metadata->toArray()"
                             action="{{ route('users.events.update', ['me', $event]) }}" />
            <x-slot name="footer">
              <button class="button is-primary preserve-rounding"
                      form="edit-event-form"
                      type="submit"
                      x-on:click="show = false">
                Update
              </button>
            </x-slot>
          </x-modal>
          <button class="button is-dark"
                  form="edit-event-form"
                  type="submit">Save</button>
        </div>

      </div>
    </div>
  </x-container>
</x-layout>
