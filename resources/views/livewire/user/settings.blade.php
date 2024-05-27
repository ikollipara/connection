<div>
  <x-hero class="is-primary">
    <div class="is-flex is-justify-content-space-between is-align-items-center">
      <h1 class="title is-3 mb-0">Settings</h1>
      <div class="buttons">
        <button type="button" wire:click='deleteAvatar' wire:loading.class='is-loading' wire:target='deleteAvatar'
          class="button is-danger is-outlined">
          Delete Profile Picture
        </button>
        <button form="settings-form" wire:target='save' wire:loading.class='is-loading' class="button is-outlined"
          type="submit">Update</button>
        @livewire('delete-account', ['user' => $this->user])
      </div>
    </div>
  </x-hero>
  <main class="container is-fluid mt-5">
    <form id="settings-form" class="columns is-multiline" wire:submit.prevent='save'>
      <div class="column is-4">
        <h2 class="title is-4">Profile Picture</h2>
        <p class="subtitle is-6">Upload a profile picture</p>
        <div class="image mb-3 is-128x128">
          <img
            @if ($this->avatar) src="{{ $this->avatar->temporaryUrl() }}" @else src="{{ $this->user->avatar() }}" @endif
            alt="Profile Picture">
        </div>
        <div x-data="{ filename: 'No File Uploaded' }" class="control">
          <div class="file has-name is-fullwidth">
            <label class="file-label">
              <input type="file" class="file-input"
                @@change="filename = $event.target.files[0].name" accept="image/*"
                wire:model.lazy='avatar'>
              <span class="file-cta">
                <span class="file-icon">
                  <x-lucide-upload width="50" height="50" />
                </span>
                <span class="file-label">
                  Choose a file...
                </span>
              </span>
              <span class="file-name" x-text='filename'>No File Uploaded</span>
            </label>
          </div>
        </div>
      </div>
      <div x-data="{ show: false }" class="column is-8">
        <x-forms.input wire:model.defer='user.first_name' label="First Name" name="first_name" />
        <x-forms.input wire:model.defer='user.last_name' label="Last Name" name="last_name" />
        <x-forms.input wire:model.defer='user.email' label="Email" name="email" type="email" />
        <x-forms.input wire:model.defer='user.school' label="School" name="school" />
        <x-forms.input wire:model.defer='user.subject' label="Subject" name="subject" />
        <x-forms.grades multiple wire:model.defer='user.grades' label="grades" name="grades" />
        <div class="field">
          <label class="checkbox">
            <input type="checkbox" wire:model.defer='user.no_comment_notifications'>
            I do not want to recieve comment notifications
          </label>
        </div>
        <button type="button" @@click='show = true;' class="button is-primary">
          See Consent Status
        </button>
        <x-modal title="conneCTION Consent Form" show-var="show">
          <x-research.consent-form>
            <span x-data="{ checked: @entangle('user.consented').defer, above: false, fullName: '' }">
              <div class="field">
                <label class="checkbox">
                  <input type="checkbox" x-model='checked'>
                  I want to participate in the conneCTION Research Study
                </label>
              </div>
              <div class="field">
                <label class="checkbox" x-bind:class="{ 'is-hidden': !checked }">
                  <input type="checkbox" x-model='above'>
                  I am 19 years or older
                </label>
              </div>
              <span x-show="above">
                <x-forms.input label="Please enter your full name to consent." x-model="fullName" name="full_name" />
              </span>
            </span>
          </x-research.consent-form>
          <x-slot name="footer">
            <button type="button" wire:click='modifyConsentStatus' x-on:click="show = false"
              class="button is-primary">Update Consent</button>
          </x-slot>
        </x-modal>
        <hr>
        <div>
          <label class="label">Bio</label>
          <p class="content">
            Write a short bio about yourself.
          </p>
          <x-editor wire:model.defer='body' name="bio" />
        </div>
      </div>
</div>
</form>
</main>
</div>
