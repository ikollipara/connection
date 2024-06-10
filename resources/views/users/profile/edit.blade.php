{{--
file: resources/views/users/profile/edit.blade.php
author: Ian Kollipara
date: 2024-06-07
description: This file contains the HTML for editing a user's profile.
 --}}

@php
  $title = 'conneCTION - Edit My Profile';
  $consented = $user->consented ? 'true' : 'false';
  $fullName = $user->consented ? $user->full_name : '';
@endphp

<x-layout :title="$title" no-livewire x-data="{ show: false }">
  <x-hero class="is-primary">
    <div class="is-flex is-justify-content-space-between is-align-items-center">
      <h1 class="title is-1 mb-0">Edit Profile</h1>
      <div class="buttons">
        <button form="profile-form" class="button is-light" type="submit">Update</button>
        <button x-on:click="show = true" class="button is-dark">Update Consent Status</button>
        <x-users.delete-account :user="$user" />
      </div>
    </div>
  </x-hero>
  <x-container x-data="{ checked: {{ $consented }}, above: {{ $consented }}, fullName: '{{ $fullName }}' }" is-fluid class="mt-5">
    @if (session('success'))
      <div class="notification is-success" x-data x-init="$el.classList.add('animate__animated', 'animate__delay-2s', 'animate__fadeOut');
      setTimeout(() => { $el.remove() }, 3000)">
        <button class="delete" x-on:click="$root.remove()"></button>
        {{ session('success') }}
      </div>
    @endif
    @if (session('error'))
      <div class="notification is-danger" x-data x-init="$el.classList.add('animate__animated', 'animate__delay-2s', 'animate__fadeOut');
      setTimeout(() => { $el.remove() }, 3000)">
        <button class="delete" x-on:click="$root.remove()"></button>
        {{ session('error') }}
      </div>
    @endif
    <form enctype="multipart/form-data" action="{{ route('users.profile.update', 'me') }}" method="post"
      id="profile-form" class="columns">
      @csrf
      @method('PATCH')
      <section id="profile-picture-and-bio" class="column is-4">
        <x-forms.image name="avatar" label="Profile Picture" />
        <x-forms.field name="bio" label="Bio">
          <x-editor name="bio" value="{!! json_encode($user->profile->bio) !!}" />
        </x-forms.field>
      </section>
      <section x-data="{ isPreservice: @js($user->profile->is_preservice) }" id="profile-other-details" class="column is-8">
        <x-forms.input name="first_name" label="First Name" value="{{ $user->first_name }}" />
        <x-forms.input name="last_name" label="Last Name" value="{{ $user->last_name }}" />
        <x-forms.input name="email" label="Email" type="email" value="{{ $user->email }}" />
        <label class="checkbox">
          <input type="checkbox" name="is_preservice" x-model="isPreservice">
          I am a preservice teacher
        </label>
        <template x-if="!isPreservice">
          <span>
            <x-forms.input name="school" label="School" value="{{ $user->profile->school }}" />
            <x-forms.input name="years_of_experience" label="Years of Experience" type="number" min="0"
              value="{{ $user->profile->years_of_experience }}" />
          </span>
        </template>
        <x-forms.input name="subject" label="Subject" value="{{ $user->profile->subject }}" />
        <x-forms.field name="grades" label="Grades">
          <x-forms.grades name="grades" label="Grades" multiple :selected="$user->profile->grades" />
        </x-forms.field>
      </section>
    </form>
    <x-modal title="conneCTION Consent Form" show-var="show">
      <form action="{{ route('users.profile.update', 'me') }}" method="post" id="update-consent-form">
        @csrf
        @method('PATCH')
        <x-research.consent-form>
          <div class="field">
            <label class="checkbox">
              <input type="checkbox" name="consented" x-model='checked'>
              I want to participate in the conneCTION Research Study
            </label>
          </div>
          <div class="field">
            <label class="checkbox" x-bind:class="{ 'is-hidden': !checked }">
              <input type="checkbox" x-model="above" x-effect="if(!checked) above = false;">
              I am 19 years or older
            </label>
          </div>
          <span x-show="above">
            <x-forms.input label="Please enter your full name to consent." x-model="fullName" name="" />
          </span>
        </x-research.consent-form>
      </form>
      <x-slot name="footer">
        <div class="buttons">
          <button type="button" x-on:click="show = false" class="button is-danger">Cancel</button>
          <button type="submit" x-bind:disabled="checked && !above && fullName.length == 0" form="update-consent-form"
            class="button is-primary">
            Update Consent
          </button>
        </div>
      </x-slot>
    </x-modal>
  </x-container>
</x-layout>
