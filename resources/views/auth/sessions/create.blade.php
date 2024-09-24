{{--
file: resources/views/auth/sessions/create.blade.php
author: Ian Kollipara
date: 2024-09-08
description: The login form for the user to enter their credentials.
 --}}

<x-guest-layout title="Login">
  <section class="bg-white dark:bg-gray-900">
    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
      <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">Login</h2>
      <x-form class="flex flex-col gap-y-4"
              form-name="login"
              action="{{ route('login') }}"
              method="post">
        <x-form-input name="email"
                      type="email"
                      label="Email" />
        <x-form-input-success message="Check your email for the login link." />
        <x-form-input-error name="email"
                            message="Invalid credentials. Try signing up." />
        <x-form-submit label="Login" />
      </x-form>
    </div>
  </section>
</x-guest-layout>
