{{--
file: resources/views/components/videos/episode.blade.php
author: Ian Kollipara
date: 2024-06-24
description: A component for displaying a video episode
 --}}

@props(['episode' => null])

@push('scripts')
  <script>
    const episodeSlugMap = {
      1: 'Episode-1-Searching',
      2: 'Episode-2-Collections',
      3: 'Episode-3-How-to-Follow-and-Comment',
      4: 'Episode-4-Posts',
      5: 'Episode-5-Profiles',
      6: 'Episode-6-Goals',
    };
    const episodeNameMap = {
      1: 'Searching',
      2: 'Collections',
      3: 'How to Follow and Comment',
      4: 'Posts',
      5: 'Profiles',
      6: 'Goals',
    };
  </script>
@endpush

<article {{ $attributes }}>
  <h2 class="title is-3" x-text="`Episode ${currentEpisode} - ${episodeNameMap[currentEpisode]}`"></h2>
  <hr>
  <video x-show="currentEpisode == 1" controls class="mx-4 my-4">
    <source src="/storage/episodes/Episode-1-Searching.mp4" encode="video/mp4">
  </video>
  <video x-show="currentEpisode == 2" controls class="mx-4 my-4">
    <source src="/storage/episodes/Episode-2-Collections.mp4" encode="video/mp4">
  </video>
  <video x-show="currentEpisode == 3" controls class="mx-4 my-4">
    <source src="/storage/episodes/Episode-3-How-to-Follow-and-Comment.mp4" encode="video/mp4">
  </video>
  <video x-show="currentEpisode == 4" controls class="mx-4 my-4">
    <source src="/storage/episodes/Episode-4-Posts.mp4" encode="video/mp4">
  </video>
  <video x-show="currentEpisode == 5" controls class="mx-4 my-4">
    <source src="/storage/episodes/Episode-5-Profiles.mp4" encode="video/mp4">
  </video>
  <video x-show="currentEpisode == 6" controls class="mx-4 my-4">
    <source src="/storage/episodes/Episode-6-Goals.mp4" encode="video/mp4">
  </video>
</article>
