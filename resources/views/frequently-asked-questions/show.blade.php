{{--
file: resources/views/frequently-asked-questions/show.blade.php
author: Ian Kollipara
date: 2024-06-03
description: Frequently Asked Questions (FAQ) show page
 --}}

@php
  $title = 'conneCTION' . __($question->title);
@endphp

<x-layout :title="$title">
  <x-hero class="is-primary">
    <a href="{{ route('faq.index') }}" class="link icon-text">
      <span class="icon">
        <x-lucide-chevron-left height="30" width="30" />
      </span>
      <span>Back to FAQ</span>
    </a>
    <h1 class="title">{{ $question->title }}</h1>
    <p class="subtitle is-3">
      {{ __($question->content) }}
    </p>
  </x-hero>
  <x-container is-fluid class="mt-5">
    @if (session('success'))
      <div class="notification is-success">
        {{ session('success') }}
      </div>
    @endif
    @if ($question->is_answered)
      <h2 class="title is-3">Answered on {{ $question->answered_at->toDayDateTimeString() }}</h2>
      <p class="content is-medium">
        {{ __($question->answer) }}
      </p>
    @else
      <p class="content is-medium">
        This question has not been answered yet.
        We'll get back to you as soon as possible.
      </p>
    @endif
  </x-container>
</x-layout>
