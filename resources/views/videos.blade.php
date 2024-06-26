{{--
file: resources/views/videos.blade.php
author: Ian Kollipara
date: 2024-06-24
description: Videos index view
 --}}

@php
  $episodes = [
      1 => 'Searching',
      2 => 'Collections',
      3 => 'How to Follow and Comment',
      4 => 'Posts',
      5 => 'Profiles',
      6 => 'Goals',
  ];
@endphp

<x-layout title="conneCTION - Video Series">
  <x-hero class="is-primary">
    <h1 class="title is-1">What is conneCTION?</h1>
    <p class="subtitle">
      Want a fuller understanding of conneCTION? Check out these videos made by the main developer himself, Ian
      Kollipara!
    </p>
  </x-hero>
  <x-container is-fluid class="mt-5 columns is-desktop" x-data="{ currentEpisode: 1 }">
    <nav class="column is-one-quarter is-hidden-touch menu">
      <p class="menu-label">Episodes</p>
      <ul class="menu-list">
        @foreach ($episodes as $episode_id => $episode)
          <li>
            <a x-on:click="currentEpisode = {{ $episode_id }}"
              x-bind:class="{ 'is-active': currentEpisode == {{ $episode_id }} }">
              {{ $episode }}
            </a>
          </li>
        @endforeach
      </ul>
    </nav>
    <x-videos.episode
      class="column is-three-quarters is-flex is-flex-direction-column is-justify-content-center is-align-items-center" />
    <div class="buttons is-hidden-desktop is-justify-content-center">
      <button x-on:click="currentEpisode--" x-bind:disabled="currentEpisode == 1" type="button" class="button is-link">
        <x-bulma-icon icon="lucide-arrow-left">
          Previous
        </x-bulma-icon>
      </button>
      <button x-on:click="currentEpisode++" x-bind:disabled="currentEpisode == 6" type="button"
        x-bind:class="{ 'is-outlined': currentEpisode != 6 }" class="button is-link is-outlined">
        <x-bulma-icon icon="lucide-arrow-right">
          Next
        </x-bulma-icon>
      </button>
    </div>
  </x-container>
</x-layout>
