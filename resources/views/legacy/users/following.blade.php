{{--
file: resources/views/users/following.blade.php
author: Ian Kollipara
date: 2024-06-06
description: This file contains the HTML for displaying the users that follow the given user.
 --}}

<x-reading-layout :title='"$user->full_name Follows"'
                  wrapper-class="xl:!mx-5 xl:!ml-64">
  <x-slot:aside>
    @include('users.followers.partials.details-sidebar', ['user' => $user, 'title' => 'Follows'])
  </x-slot>
  @forelse ($following as $follower)
    @include('users.followers.partials.follower-card', ['user' => $follower])
  @empty
    <p>{{ $user->full_name }} does not follow anyone</p>
  @endforelse
</x-reading-layout>
