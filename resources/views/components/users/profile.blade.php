{{--
file: resources/views/components/users/profile.blade.php
author: Ian Kollipara
date: 2024-06-06
description: This file contains the HTML for displaying a user's profile.
 --}}

@props(['user'])

<div class="is-flex" style="gap: 1rem;">
  <figure class="image is-128x128 mt-auto mb-auto">
    <img loading="lazy" src="{{ $user->avatar }}" alt="{{ $user->full_name }}">
  </figure>
  <article class="is-flex is-flex-direction-column">
    <h1 class="title is-1">{{ $user->full_name }}</h1>
    <section class="is-flex is-justify-content-start is-align-items-center" style="gap: 1rem;">
      <a href="{{ route('users.followers.index', $user) }}" class="is-link">{{ $user->followers_count }} Followers</a>
      <a href="{{ route('users.following.index', $user) }}" class="is-link">{{ $user->following_count }} Following</a>
    </section>
    <p class="is-italic content">
      {{ $user->profile->short_title }}
      @foreach ($user->profile->grades as $grade)
        <span class="tag is-link">{{ $grade->label }}</span>
      @endforeach
    </p>
  </article>
</div>
