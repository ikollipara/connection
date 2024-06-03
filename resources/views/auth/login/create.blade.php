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
  <x-container is-fluid class="mt-5">
    @if (session()->has('success'))
      <div class="notification is-success">
        {{ session('success') }}
      </div>
    @endif
    <form action="{{ route('login.store') }}" method="post" class="mt-5 mb-5">
      @csrf
      <x-forms.input label="Email" name="email" />
      <button x-on:click="$el.classList.add('is-loading')" type="submit" class="button is-primary">Login</button>
    </form>
  </x-container>
</x-layout>
