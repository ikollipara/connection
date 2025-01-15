{{--
file: resources/views/users/settings/edit.blade.php
author: Ian Kollipara
date: 2024-06-07
description: This file contains the HTML for editing a user's settings.
 --}}

@php
  $title = 'conneCTION - Edit Settings';
@endphp

<x-layout :title="$title"
          no-livewire>
  <x-hero class="is-primary">
    <div class="is-flex is-justify-content-space-between is-align-items-center">
      <h1 class="title is-1 mb-0">Edit Settings</h1>
      <div class="buttons">
        <button class="button is-light"
                form="settings-form"
                type="submit">Update</button>
      </div>
  </x-hero>
  <x-container class="mt-5"
               is-fluid>
    @if (session('success'))
      <div class="notification is-success"
           x-data
           x-init="$el.classList.add('animate__animated', 'animate__delay-2s', 'animate__fadeOut');
           setTimeout(() => { $el.remove() }, 3000)">
        <button class="delete"
                x-on:click="$root.remove()"></button>
        {{ session('success') }}
      </div>
    @endif
    @if (session('error'))
      <div class="notification is-danger"
           x-data
           x-init="$el.classList.add('animate__animated', 'animate__delay-2s', 'animate__fadeOut');
           setTimeout(() => { $el.remove() }, 3000)">
        <button class="delete"
                x-on:click="$root.remove()"></button>
        {{ session('error') }}
      </div>
    @endif
    <form class="is-flex is-flex-direction-column content is-medium"
          id="settings-form"
          style="gap: 1em;"
          action="{{ route('users.settings.update', 'me') }}"
          method="post">
      @csrf
      @method('PATCH')
      <label class="checkbox is-hidden">
        <input name="receive_weekly_digest"
               type="checkbox"
               @if (old('receive_weekly_digest') ?? $user->settings->receive_weekly_digest) checked @endif>
        Receive a weekly digest of the most popular posts and collections.
      </label>
      <label class="checkbox is-hidden">
        <input name="receive_comment_notifications"
               type="checkbox"
               @if (old('receive_comment_notifications') ?? $user->settings->receive_comment_notifications) checked @endif>
        Receive notifications when one of your posts or collections receives a comment
      </label>
      <label class="checkbox is-hidden">
        <input name="receive_new_follower_notifications"
               type="checkbox"
               @if (old('receive_new_follower_notifications') ?? $user->settings->receive_new_follower_notifications) checked @endif>
        Receive notifications for new followers
      </label>
      <label class="checkbox">
        <input name="receive_follower_notifications"
               type="checkbox"
               @if (old('receive_follower_notifications') ?? $user->settings->receive_follower_notifications) checked @endif>
        Receive notifications for new posts and collections from teachers you follow
      </label>
    </form>
  </x-container>
</x-layout>
