{{--
file: resources/views/components/users/delete-account.blade.php
author: Ian Kollipara
date: 2024-06-10
description: This file contains the HTML for the delete account component.
 --}}

@props(['user'])

<span x-data="{ show: false }">
  <button x-on:click="show = true" class="button is-danger">
    Delete Account
  </button>
  <x-modal show-var="show" title="Delete Account">
    <form id="delete-account-form" action="{{ route('users.destroy', ['user' => $user]) }}" method="POST">
      @csrf
      @method('DELETE')
      <p class="content is-large has-text-danger">Are You Sure? All of your content will remain on the site and you will
        be
        unable to reclaim it!</p>
    </form>
    <x-slot name="footer">
      <button class="button is-danger mr-2" form="delete-account-form" type="submit">Delete Account</button>
      <button @@click="show = false" class="button is-primary">Cancel</button>
    </x-slot>
  </x-modal>
</span>
