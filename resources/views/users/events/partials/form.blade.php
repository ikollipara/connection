{{--
file: resources/views/users/events/partials/form.blade.php
author: Ian Kollipara
date: 2024-09-23
description: The form for creating or updating an event
 --}}

@include('users.events.partials.auto-save-warning')
<x-form action="{{ $action }}"
        method="{{ $method }}"
        x-data
        x-on:save.window.once="
        if(!localStorage.getItem('warned'))
            alert('The Event does not autosave. Please remember to save your changes. This is found in the drawer. (Click Edit Details)')
        localStorage.setItem('warned', true);
        "
        :model="$event">
  <x-form-input class="bg-none border-none bg-transparent !text-4xl leading-none tracking-tight text-gray-900 focus:ring-0 focus:border-b focus:border-blue-700 px-0 mb-5 py-0"
                name="title"
                x-on:input="$dispatch('editor:unsaved')"
                placeholder="Post Title..." />
  <x-form-rich-text name="description"
                    :value="$event->description->toJson()" />
  @include('users.events.partials.edit-details-drawer', [
      'event' => $event,
      'name' => $drawerName,
  ])
</x-form>
