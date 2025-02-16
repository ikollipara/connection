{{--
file: resources/views/users/events/create.blade.php
author: Ian Kollipara
date: 2024-09-23
description: The HTML for the user's events create page
 --}}

<x-writing-layout title="New Event"
                  drawer-name="create-event-drawer"
                  show-drawer
                  drawer-title="Edit Details">
  @include('users.events.partials.form', [
      'action' => route('users.events.store', 'me'),
      'formName' => 'create-event',
      'event' => $event,
      'method' => 'post',
      'drawerName' => 'create-event-drawer',
      'drawerAction' => route('users.events.store', 'me'),
  ])
</x-writing-layout>
