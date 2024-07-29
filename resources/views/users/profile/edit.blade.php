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

<x-layout :title="$title"
          no-livewire
          x-data="{ show: false }">
  <x-hero class="is-primary">
    <div class="is-flex is-justify-content-space-between is-align-items-center">
      <h1 class="title is-1 mb-0">Edit Profile</h1>
      <div class="buttons">
        <button class="button is-light"
                form="profile-form"
                type="submit">Update</button>
        <x-modal title="conneCTION Consent Form"
                 x-data="{ checked: {{ $user->consented ? 'true' : 'false' }}, above: {{ $user->consented ? 'true' : 'false' }}, fullName: '{{ $user->consented ? $user->full_name : '' }}' }"
                 btn="Update Consent Status"
                 btn-class="is-dark">
          <form id="update-consent-form"
                action="{{ route('users.consent.update', 'me') }}"
                method="post">
            @csrf
            @method('PATCH')
            <x-research.consent-form>
              <div class="field">
                <label class="checkbox">
                  <input name="consented"
                         type="checkbox"
                         x-model='checked'>
                  I want to participate in the conneCTION Research Study
                </label>
              </div>
              <div class="field">
                <label class="checkbox"
                       x-bind:class="{ 'is-hidden': !checked }">
                  <input type="checkbox"
                         x-model="above"
                         x-effect="if(!checked) above = false;">
                  I am 19 years or older
                </label>
              </div>
              <span x-show="above">
                <x-forms.input name=""
                               label="Please enter your full name to consent."
                               x-model="fullName" />
              </span>
            </x-research.consent-form>
          </form>
          <x-slot name="footer">
            <div class="buttons">
              <button class="button is-danger"
                      type="button"
                      x-on:click="show = false">Cancel</button>
              <button class="button is-primary"
                      form="update-consent-form"
                      type="submit"
                      x-bind:disabled="checked && !above && fullName.length == 0">
                Update Consent
              </button>
            </div>
          </x-slot>
        </x-modal>
        <x-users.delete-account :user="$user" />
      </div>
    </div>
  </x-hero>
  <x-container class="mt-5"
               x-data="{ checked: {{ $consented }}, above: {{ $consented }}, fullName: '{{ $fullName }}' }"
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
    <form class="columns"
          id="profile-form"
          enctype="multipart/form-data"
          action="{{ route('users.profile.update', 'me') }}"
          method="post">
      @csrf
      @method('PATCH')
      <section class="column is-4"
               id="profile-picture-and-bio">
        <x-forms.image name="avatar"
                       label="Profile Picture" />
        <x-forms.field name="bio"
                       label="Bio">
          <x-editor name="bio"
                    value="{!! json_encode($user->profile->bio) !!}" />
        </x-forms.field>
      </section>
      <section class="column is-8"
               id="profile-other-details"
               x-data="{ isPreservice: @js($user->profile->is_preservice) }">
        <x-forms.input name="first_name"
                       value="{{ $user->first_name }}"
                       label="First Name" />
        <x-forms.input name="last_name"
                       value="{{ $user->last_name }}"
                       label="Last Name" />
        <x-forms.input name="email"
                       type="email"
                       value="{{ $user->email }}"
                       label="Email" />
        <label class="checkbox">
          <input name="is_preservice"
                 type="checkbox"
                 x-model="isPreservice">
          I am a preservice teacher
        </label>
        <template x-if="!isPreservice">
          <span>
            <x-forms.input name="school"
                           value="{{ $user->profile->school }}"
                           label="School" />
            <x-forms.input name="years_of_experience"
                           type="number"
                           value="{{ $user->profile->years_of_experience }}"
                           label="Years of Experience"
                           min="0" />
          </span>
        </template>
        <x-forms.input name="subject"
                       value="{{ $user->profile->subject }}"
                       label="Subject" />
        <x-forms.field name="grades"
                       label="Grades">
          <x-forms.grades name="grades"
                          label="Grades"
                          multiple
                          :selected="$user->profile->grades" />
        </x-forms.field>
      </section>
    </form>
  </x-container>
</x-layout>
