{{--
file: resources/views/auth/register/create.blade.php
author: Ian Kollipara
date: 2024-09-23
description: This file contains the form for registering a new user.
 --}}

<x-guest-layout title="Sign Up">
  <section class="bg-white dark:bg-gray-900">
    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md flex flex-col">
      <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">Sign Up</h2>

      <x-form class="flex flex-col gap-y-4"
              form-name="sign-up"
              action="{{ route('register') }}"
              method="post">
        <div class="md:flex">
          <ul class="flex-column space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 md:me-4 mb-4 md:mb-0"
              data-tabs-toggle="#register-sections"
              role="tablist">
            <li role="presentation">
              <button class="inline-flex items-center px-4 py-3 [aria-selected=true]:text-white [aria-selected=true]:bg-blue-700 rounded-lg [aria-selected=true]:active w-full [aria-selected=true]:dark:bg-blue-600 hover:text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white"
                      id="account-information-tab"
                      data-tabs-target="#account-information"
                      type="button"
                      role="tab"
                      aria-controls="account-information"
                      aria-current="page">
                <x-lucide-circle class="w-4 h-4 me-2 text-blue-700" />
                Account Information
              </button>
            </li>
            <li role="presentation">
              <button class="inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white"
                      id="profile-information-tab"
                      data-tabs-target="#profile-information"
                      type="button"
                      role="tab"
                      aria-controls="profile-information">
                <x-lucide-circle class="w-4 h-4 me-2 text-blue-700" />
                Profile Information
              </button>
            </li>
            <li role="presentation">
              <button class="inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 bg-gray-50 hover:bg-gray-100 w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white"
                      id="consent-information-tab"
                      data-tabs-target="#consent-information"
                      type="button"
                      role="tab"
                      aria-controls="consent-information">
                <x-lucide-circle class="w-4 h-4 me-2 text-blue-700" />
                Informed Consent
              </button>
            </li>
          </ul>
          <div class="p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full"
               id="register-sections">
            <div id="account-information"
                 role="tabpanel">@include('auth.register.partials.account-information')</div>
            <div class="hidden"
                 id="profile-information"
                 role="tabpanel">@include('auth.register.partials.profile-information')</div>
            <div class="hidden"
                 id="consent-information"
                 role="tabpanel">@include('auth.register.partials.consent-information')</div>
          </div>
      </x-form>
    </div>
  </section>
</x-guest-layout>
