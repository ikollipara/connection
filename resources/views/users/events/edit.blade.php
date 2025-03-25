{{--
file: resources/views/users/events/edit.blade.php
author: Ian Kollipara
date: 2024-09-23
description: The HTML for the user's event editor
 --}}

<x-writing-layout title="New Event"
                  drawer-name="update-event-drawer"
                  drawer-title="Edit Details">
  @include('users.events.partials.form', [
      'action' => route('users.events.update', ['me', $event]),
      'formName' => 'update-event',
      'event' => $event,
      'method' => 'put',
      'drawerName' => 'update-event-drawer',
      'drawerAction' => route('users.events.update', ['me', $event]),
  ])
</x-writing-layout>
