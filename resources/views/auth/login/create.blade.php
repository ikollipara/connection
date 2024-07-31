{{--
file: resources/views/auth/login/create.blade.php
author: Ian Kollipara
date: 2024-06-03
description: The login form for the user to enter their credentials.
--}}

<x-layout title="conneCTION - Login">
  <x-hero class="is-primary">
    <h1 class="title">Login</h1>
  </x-hero>
  <x-container class="mt-5"
               is-fluid>
    <x-form form-name="loginForm"
            action="{{ route('login.store') }}">
      <x-form.input name="email"
                    type="email"
                    label="Email" />
      <x-form.submit class="is-primary"
                     label="Login" />
    </x-form>
  </x-container>
</x-layout>
