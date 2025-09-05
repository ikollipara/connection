{{--
file: resources/views/auth/register/partials/account-information.blade.php
author: Ian Kollipara
date: 2024-09-23
description: This file contains the form for the user to enter their account information during registration.
 --}}

<h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Account Information</h3>
<div class="mb-2">
  <label class="block mb-3"
         for="">
    <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">First Name</span>
    <x-form-input name="first_name"
                  type="text"
                  required />
    <x-form-input-error name="first_name" />
  </label>
  <label class="block mb-3"
         for="">
    <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">Last Name</span>
    <x-form-input name="last_name"
                  type="text"
                  required />
    <x-form-input-error name="last_name" />
  </label>
  <label class="block mb-3"
         for="">
    <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">Email</span>
    <x-form-input name="email"
                  type="email"
                  required />
    <x-form-input-error name="email" />
  </label>
  <button class="text-blue-600 float-right"
          type="button"
          x-data
          x-on:click="document.querySelector('#profile-information-tab').click()">Next</button>
</div>
