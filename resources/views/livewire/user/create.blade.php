<div>
  <x-hero class="is-primary">
    <h1 class="title">Sign Up</h1>
  </x-hero>
  <x-container is-fluid class="mt-5 mb-5">
    <form wire:submit.prevent='save' class="columns is-multiline" enctype="multipart/form-data" method="post"
      x-data="{ step: 0, isPreservice: @entangle('user.is_preservice').defer }">
      <section class="column is-half" x-show="step == 0">
        <article>
          <h2 class="subtitle is-3 has-text-centered">Personal Information</h2>
          <x-forms.input label="First Name" name="first_name" wire:model.debounce.200ms="user.first_name" />
          <x-forms.input label="Last Name" name="last_name" wire:model.debounce.200ms="user.last_name" />
          <x-forms.input label="Email" name="email" type="email" wire:model.debounce.200ms="user.email" />
        </article>
        <article>
          <h2 class="subtitle is-3 has-text-centered">Teacher Information</h2>
          <div class="field">
            <label for="grades" class="label">Grades</label>
            <div class="field has-addons">
              <div class="control is-expanded">
                <x-forms.grades wire:model="user.grades" multiple />
              </div>
            </div>
          </div>
          <label class="checkbox">
            <input type="checkbox" x-model="isPreservice">
            I am a preservice teacher
          </label>
          <span x-show="!isPreservice"><x-forms.input label="School" name="school"
              wire:model.debounce.200ms="user.school" /></span>
          <span x-show="!isPreservice">
            <x-forms.input label="Years of Experience" name="years_of_experience" type="number"
              wire:model.debounce.200ms="user.years_of_experience" />
          </span>
          <x-forms.input label="Subject" name="subject" wire:model.debounce.200ms="user.subject" />
        </article>
      </section>
      <section class="column is-half" x-show="step == 0">
        <article>
          <h2 class="subtitle is-3 has-text-centered">Your Profile Information</h2>
          <div class="level is-justify-content-center">
            <x-forms.image label="Avatar" name="avatar" wire:model.debounce.200ms="avatar" />
          </div>
          <x-editor name="bio" wire:model="bio" cannot-upload />
        </article>
      </section>
      <button type="button" x-on:click="step++" class="button is-primary is-fullwidth" x-show="step==0">Next</button>
      <section class="column is-fullwidth" x-data="{ checked: @entangle('user.consented').defer, above: false, fullName: '' }" x-show="step == 1">
        <h2 class="subtitle is-3 has-text-centered">conneCTION Research Study</h2>
        <x-research.consent-form>
          <div class="field">
            <label class="checkbox">
              <input type="checkbox" x-model='checked'>
              I want to participate in the conneCTION Research Study
            </label>
          </div>
          <div class="field">
            <label class="checkbox" x-bind:class="{ 'is-hidden': !checked }">
              <input type="checkbox" x-model="above">
              I am 19 years or older
            </label>
          </div>
          <span x-show="above">
            <x-forms.input label="Please enter your full name to consent." x-model="fullName" name="full_name" />
          </span>
        </x-research.consent-form>
        <section class="column is-fullwidth" x-show="step == 1">
          <div class="is-flex" style="gap: 1em">
            <button type="button" x-on:click="step--" class="button is-primary" style="width: 50%;">Previous</button>
            <button type="button" x-bind:disabled="checked && !above && fullName==''" x-on:click="step++"
              class="button is-primary" style="width: 50%;">Sign Up</button>
          </div>
        </section>
      </section>
    </form>
  </x-container>
  {{-- <main x-data="{ isPreservice: @entangle('user.is_preservice').defer }" class="container is-fluid mt-5">
    <form wire:submit.prevent='save' class="mt-5 mb-5" enctype="multipart/form-data" method="post">
      <div class="field is-group is-grouped-centered">
        <div class="control">
          <button type="button" x-on:click="currentStep--" class="button is-primary is-outlined">
            Back
          </button>
          <button x-bind:disabled="checked && !above && fullName===''" type="submit" class="button is-primary">
            Submit
          </button>
        </div>
      </div>
      </section>
    </form>
  </main> --}}
</div>
