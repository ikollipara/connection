{{--
file: resources/views/auth/register/partials/profile-information.blade.php
author: Ian Kollipara
date: 2024-09-23
description: This file contains the form for the user to enter their profile information during registration.
 --}}

@use('App\Enums\Grade')

<h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Profile Information</h3>
<div class="mb-2"
     x-data="{ isPreservice: false }">
  <label class="block mb-3"
         for="">
    <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">Grades</span>
    <x-form-select name="grades"
                   required
                   :options="Grade::cases()"
                   multiple />
    <x-form-input-error name="grades" />
  </label>
  <label class="block mb-3"
         for="">
    <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">School</span>
    <x-form-input name="school"
                  type="text"
                  required />
    <x-form-input-error name="school" />
  </label>
  <label class="block mb-3"
         for="">
    <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">Subject</span>
    <x-form-input name="subject"
                  type="text"
                  required />
    <x-form-input-error name="subject" />
  </label>
  <div class="flex items-center mb-4">
    <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
           id="is_preservice"
           name="is_preservice"
           type="checkbox"
           x-model="isPreservice" />
    <label class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
           for="is_preservice">I am a pre-service teacher</label>
  </div>
  <template x-if="!isPreservice">
    <label class="block mb-3">
      <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Years of Experience
      </span>
      <x-form-input name="years_of_experience"
                    type="number"
                    required
                    min="0" />
      <x-form-help-text message="How many years you have taught. If you are in your first year, please put 0." />
      <x-form-input-error name="years_of_experience" />
    </label>
  </template>
  <label class="block mb-3">
    <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
      Profile Biography
    </span>
    <x-form-help-text
                      message="Your profile biography. This is shown to all visitors of your profile, so make it count!" />
    <x-form-input-error name="bio" />
    <x-form-rich-text name="bio" />
  </label>
  <div class="flex gap-x-3 justify-end">
    <button type="button"
            x-data
            x-on:click="document.querySelector('#account-information-tab').click()">Previous</button>
    <button class="text-blue-600"
            type="button"
            x-data
            x-on:click="document.querySelector('#consent-information-tab').click()">Next</button>
  </div>
</div>
