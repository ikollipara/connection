{{--
file: resources/views/users/followers/index.blade.php
author: Ian Kollipara
date: 2024-06-06
description: This file contains the HTML for displaying a user's followers.
 --}}

@php
  $title = 'conneCTION - ' . $user->full_name . '\'s Followers';
@endphp

<x-layout :title="$title"
          no-livewire>
  <x-hero class="is-primary">
    <a class="icon-text is-link mt-3 mb-3"
       href="{{ route('users.show', $user) }}">
      <span class="icon">
        <x-lucide-arrow-left class="icon"
                             width="30"
                             height="30"
                             fill="none" />
      </span>
      <span>Back to Profile</span>
    </a>
    <x-users.profile :user="$user" />
  </x-hero>
  <x-container class="mt-5"
               is-fluid>
    <table class="table is-fullwidth">
      <tbody>
        @forelse ($followers as $follower)
          <x-users.row :user="$follower" />
        @empty
          <tr>
            <td>
              <h2 class="subtitle is-3">{{ $user->full_name }} does not follow anyone.</h2>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
    {{ $followers->links('pagination') }}
  </x-container>
</x-layout>
