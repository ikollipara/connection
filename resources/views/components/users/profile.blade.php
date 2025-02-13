{{--
file: resources/views/components/users/profile.blade.php
author: Ian Kollipara
date: 2024-06-06
description: This file contains the HTML for displaying a user's profile.
 --}}

@props(['user'])

@php
  $is_follower = $user->followers->contains(auth()->user());
  $route = $is_follower ? route('users.followers.destroy', [$user, auth()->user()]) : route('users.followers.store', $user);
@endphp

<div class="is-flex"
     style="gap: 1rem;">
  <figure class="image is-128x128 mt-auto mb-auto">
    <img src="{{ $user->avatar }}"
         alt="{{ $user->full_name }}"
         loading="lazy">
  </figure>
  <article class="is-flex is-flex-direction-column">
    <h1 class="title is-1">{{ $user->full_name }}</h1>
    <section class="is-flex is-justify-content-start is-align-items-center"
             style="gap: 1rem;">
      <a class="is-link"
         href="{{ route('users.followers.index', $user) }}">{{ $user->followers_count }} Followers</a>
      <a class="is-link"
         href="{{ route('users.following.index', $user) }}">{{ $user->following_count }} Following</a>
    </section>
    <p class="is-italic content">
      {{ $user->profile->short_title }}
      @foreach ($user->profile->grades as $grade)
        <span class="tag is-link">{{ $grade->label }}</span>
      @endforeach
    </p>
    @unless ($user->is(auth()->user()))
      <form action="{{ $route }}"
            method="post">
        @csrf
        @if ($is_follower)
          @method('DELETE')
        @else
          <input name="user_id"
                 type="hidden"
                 value="{{ auth()->id() }}">
        @endif
        <button type="submit"
                @class([
                    'button',
                    'is-success' => !$is_follower,
                    'is-danger' => $is_follower,
                ])>
          <x-bulma-icon icon="{{ $is_follower ? 'lucide-user-minus' : 'lucide-user-plus' }}">
            {{ $is_follower ? 'Unfollow' : 'Follow' }}
          </x-bulma-icon>
        </button>
      </form>
    @endunless
  </article>
</div>
