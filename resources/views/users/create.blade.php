{{--
file: resources/views/users/create.blade.php
author: Ian Kollipara
date: 2024-06-06
description: This file contains the HTML form for creating a new user.
 --}}

@php
  $title = 'conneCTION - ' . __('Sign Up');
@endphp

<x-layout :title="$title"
          no-livewire>
  <x-hero class="is-primary">
    <h1 class="title">{{ $title }}</h1>
  </x-hero>
  <x-container class="mt-5 mb-5"
               is-fluid>
    <form class="columns is-multiline"
          x-data="{ step: 0, isPreservice: false }"
          enctype="multipart/form-data"
          action="{{ route('users.store') }}"
          method="post">
      @csrf
      <section class="column is-half"
               x-show="step == 0">
        <article>
          <h2 class="subtitle is-3 has-text-centered">Personal Information</h2>
          <x-forms.input name="first_name"
                         label="First Name" />
          <x-forms.input name="last_name"
                         label="Last Name" />
          <x-forms.input name="email"
                         type="email"
                         label="Email" />
        </article>
        <article>
          <h2 class="subtitle is-3 has-text-centere">Teacher Information</h2>
          <x-forms.field name="grades"
                         label="Grades">
            <x-forms.grades name="grades"
                            multiple />
            @error('grades')
              <p class="help is-danger">{{ $message }}</p>
            @enderror
          </x-forms.field>
          <label class="checkbox">
            <input name="is_preservice"
                   type="checkbox"
                   x-model="isPreservice">
            I am a preservice teacher
          </label>
          <template x-if="!isPreservice">
            <span>
              <x-forms.input name="school"
                             label="School" />
              <x-forms.input name="years_of_experience"
                             type="number"
                             label="Years of Experience"
                             min="0" />
            </span>
          </template>
          <x-forms.input name="subject"
                         label="Subject" />
        </article>
      </section>
      <section class="column is-half"
               x-show="step == 0">
        <article>
          <h2 class="subtitle is-3 has-text-centered">Your Profile Information</h2>
          <div class="level is-justify-content-center">
            <x-forms.image name="avatar"
                           label="Avatar" />
          </div>
          <x-forms.field name="bio"
                         label="Bio">
            <x-editor name="bio"
                      value="{!! old('bio') !!}"
                      :can-upload="false" />
          </x-forms.field>
        </article>
      </section>
      <button class="button is-primary is-fullwidth"
              type="button"
              x-on:click="step++"
              x-show="step==0">Next</button>
      <section class="column is-fullwidth"
               x-data="{ checked: true, above: false, fullName: '' }"
               x-show="step == 1"
               x-cloak>
        <h2 class="subtitle is-3 has-text-centered">conneCTION Research Study</h2>
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
                     x-model="above">
              I am 19 years or older
            </label>
          </div>
          <span x-show="above">
            <x-forms.input name=""
                           label="Please enter your full name to consent."
                           x-model="fullName" />
          </span>
        </x-research.consent-form>
        <section class="column is-fullwidth"
                 x-show="step == 1">
          <div class="is-flex"
               style="gap: 1em">
            <button class="button is-primary"
                    type="button"
                    style="width: 50%;"
                    x-on:click="step--">Previous</button>
            <button class="button is-primary"
                    type="submit"
                    style="width: 50%;"
                    x-bind:disabled="checked && !above && fullName.length == 0"
                    x-on:click="step++">Sign Up</button>
          </div>
        </section>
      </section>
    </form>
  </x-container>
</x-layout>
