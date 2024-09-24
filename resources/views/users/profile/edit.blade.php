{{--
file: resources/views/users/profile/edit.blade.php
author: Ian Kollipara
date: 2024-06-07
description: This file contains the HTML for editing a user's profile.
 --}}

<x-authed-layout title="Edit My Profile">
  <x-title>Edit Profile</x-title>
  <main>
    <div class="w-full my-4">
      <x-form-input-success message="Profile Updated Successfully" />
    </div>
    <x-form form-name="edit-profile"
            action="{{ route('users.profile.update', 'me') }}"
            method="PUT"
            :model="$profile">
      <div class="mb-3">
        <x-form-submit label="Update Profile" />
      </div>
      <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center"
            id="default-tab"
            data-tabs-toggle="#profile-sections"
            role="tablist">
          <li class="me-2"
              role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg"
                    id="details-tab"
                    data-tabs-target="#details"
                    type="button"
                    role="tab"
                    aria-controls="details"
                    aria-selected="false">Short Details</button>
          </li>
          <li class="me-2"
              role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="avatarDescription-tab"
                    data-tabs-target="#avatarDescription"
                    type="button"
                    role="tab"
                    aria-controls="avatarDescription"
                    aria-selected="false">Avatar & Description</button>
          </li>
          <li class="me-2"
              role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="consent-tab"
                    data-tabs-target="#consent"
                    type="button"
                    role="tab"
                    aria-controls="consent"
                    aria-selected="false">Consent Status</button>
          </li>
        </ul>
      </div>
      <div id="profile-sections">
        @include('users.profile.partials.details-tab', ['profile' => $profile])
        @include('users.profile.partials.avatar-and-bio-tab', ['profile' => $profile])
        @include('users.profile.partials.consent-tab', ['user' => $user])
      </div>
    </x-form>
  </main>
</x-authed-layout>
