{{--
file: resources/views/components/notification.blade.php
author: Ian Kollipara
date: 2024-07-31
description: |
    A component for displaying notifications to the user. This component
    is designed to be used within the layout component and provides a
    consistent way to display success and error messages to the user.

    The notification contains JS code to fade out and remove itself upon
    clicking the close button.
 --}}

@props(['message', 'type' => 'success', 'notificationClass' => [], 'bodyClass' => []])

@php
  $notificationClass = is_array($notificationClass) ? $notificationClass : explode(' ', $notificationClass);
  $bodyClass = is_array($bodyClass) ? $bodyClass : explode(' ', $bodyClass);
@endphp

<div x-data="{
    remove() {
        $root.classList.remove('animate__fadeIn');
        $root.classList.add('animate__fadeOut');
        setTimeout(() => $root.remove(), 1000);
    }
}"
     @class(array_merge(
             ['notification', 'is-' . $type, 'animate__animated', 'animate__fadeIn'],
             $notificationClass))>
  <div @class(array_merge(
          ['is-flex', 'is-justify-content-between', 'is-align-items-start'],
          $bodyClass))>
    <p class="has-text-white mr-2">{{ $message }}</p>
    <button class="delete"
            type="button"
            x-on:click="remove()"></button>
  </div>
</div>
