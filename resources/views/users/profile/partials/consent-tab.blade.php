{{--
file: resources/views/users/profile/partials/consent-tab.blade.php
author: Ian Kollipara
date: 2024-09-21
description: The consent tab for the user profile
 --}}

<div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
     id="consent"
     role="tabpanel"
     aria-labelledby="consent-tab"
     x-data="{ checked: {{ Js::from($user->consented) }}, above: {{ Js::from($user->consented) }} }">
  <div class="max-h-96 overflow-y-scroll">@include('users.partials.consent')</div>
  <hr class="text-gray-900 my-4">
  <div class="flex items-center mb-4">
    <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
           id="default-checkbox"
           type="checkbox"
           x-model="checked"
           @checked($user->consented)>
    <label class="ms-2 text-base font-medium text-gray-900 dark:text-gray-300"
           for="default-checkbox">I want to participate in the conneCTION Research Study</label>
  </div>
  <div class="flex items-center mb-4">
    <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
           id="default-checkbox"
           type="checkbox"
           x-model="above"
           x-init="$watch('checked', (value) => { if (!checked) { above = false }; })"
           @checked($user->consented)>
    <label class="ms-2 text-base font-medium text-gray-900 dark:text-gray-300"
           for="default-checkbox">I am 19 years or older</label>
  </div>
  <label class="block mb-3">
    <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">Please enter your full
      name</span>
    <x-form-input id="consent-full-name"
                  name="consented[full_name]"
                  value="{{ $user->consented ? $user->full_name : '' }}"
                  x-data
                  x-init="$watch('checked', (value) => { if (!checked) { $el.value = '' }; })"
                  x-bind:required="checked" />
    <x-form-input-error name="consent.full_name" />
  </label>
</div>
