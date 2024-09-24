{{--
file: resources/views/auth/register/partials/consent-information.blade.php
author: Ian Kollipara
date: 2024-09-23
description: This file contains the form for the user to enter their consent information during registration.
 --}}
<h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Informed Consent</h3>
<div class="mb-2">
  <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
       id="consent"
       aria-labelledby="consent-tab"
       x-data="{ checked: true, above: false }">
    <div class="max-h-96 overflow-y-scroll">@include('users.partials.consent')</div>
    <hr class="text-gray-900 my-4">
    <div class="flex items-center mb-4">
      <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
             id="default-checkbox"
             type="checkbox"
             x-model="checked">
      <label class="ms-2 text-base font-medium text-gray-900 dark:text-gray-300"
             for="default-checkbox">I want to participate in the conneCTION Research Study</label>
    </div>
    <div class="flex items-center mb-4">
      <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
             id="default-checkbox"
             type="checkbox"
             x-model="above"
             x-init="$watch('checked', (value) => { if (!checked) { above = false }; })">
      <label class="ms-2 text-base font-medium text-gray-900 dark:text-gray-300"
             for="default-checkbox">I am 19 years or older</label>
    </div>
    <label class="block mb-3">
      <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">Please enter your full
        name</span>
      <x-form-input id="consent-full-name"
                    name="consented[full_name]"
                    value=""
                    x-data
                    x-init="$watch('checked', (value) => { if (!checked) { $el.value = '' }; })"
                    x-bind:required="checked" />
      <x-form-input-error name="consent.full_name" />
    </label>
  </div>
  <div class="flex gap-x-3">
    <button type="button"
            x-data
            x-on:click="document.querySelector('#profile-information-tab').click()">Previous</button>
    <button type="submit">Submit</button>
  </div>
</div>
