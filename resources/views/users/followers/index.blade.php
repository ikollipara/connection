{{--
file: resources/views/users/followers/index.blade.php
author: Ian Kollipara
date: 2024-06-06
description: This file contains the HTML for displaying a user's followers.
 --}}

<x-reading-layout :title='"Followers of $user->full_name"'
                  wrapper-class="xl:!mx-5 xl:!ml-64">
  <x-slot:aside>
    @include('users.followers.partials.details-sidebar', ['user' => $user, 'title' => 'Who Follows'])
  </x-slot>
  @forelse ($followers as $follower)
    @include('users.followers.partials.follower-card', ['user' => $follower])
  @empty
    <p>No one follows {{ $user->full_name }}</p>
  @endforelse
</x-reading-layout>
