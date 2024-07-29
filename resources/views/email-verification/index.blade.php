{{--
file: resources/views/email-verification/index.blade.php
author: Ian Kollipara
date: 2024-06-03
description: The email verification page for the user to verify their email.
--}}

<x-layout title="conneCTION - Verify Email">
  <x-hero class="is-primary">
    <h1 class="title">Verify Email</h1>
  </x-hero>
  <x-container class="mt-5"
               is-fluid>
    <p class="subtitle">
      Please check your email for a verification link. You cannot post or comment until you verify your email. This is
      to
      prevent spam, and to ensure that you are a real person. If you did not receive the email,
    </p>
    <form class="level is-justify-content-center"
          method="get"
          action="{{ route('verification.notice') }}">
      <button class="button is-primary is-outlined"
              type="submit"
              x-on:click="$el.classList.add('is-loading')">
        Click here
      </button>
    </form>
