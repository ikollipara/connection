{{--
file: resources/views/frequently-asked-questions/index.blade.php
author: Ian Kollipara
date: 2024-06-03
description: Frequently Asked Questions (FAQ) page
--}}

@php
  $title = 'conneCTION' . __('Frequently Asked Questions');
  $has_search = request()->has('q');
@endphp

<x-layout :title="$title" no-livewire>
  <form x-data action="{{ url()->current() }}" class="hero is-primary" method="get">
    <div class="hero-body">
      <x-forms.input x-on:change.debounce.200ms="$root.submit()" tabindex="0" name="q" placeholder="Search..."
        value="{{ $has_search ? request('q') : '' }}" without-label has-addons>
        <div class="control">
          <a href="{{ route('faq.create') }}" class="button is-dark">Create Question</a>
        </div>
      </x-forms.input>
    </div>
  </form>
  <x-container is-fluid class="mt-5">
    <table class="table is-fullwidth is-hoverable">
      <tbody>
        @forelse ($questions as $question)
          <tr>
            <td>{{ __($question->title) }}</td>
            <td>{{ __($question->answer_excerpt) }}</td>
            @unless ($question->history->count())
              <td>Unrated</td>
            @else
              <td>{{ $question->rating . '%' }}</td>
            @endunless
            <td>
              <a class="link" href="{{ route('faq.show', $question) }}">Visit</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="mt-5 mx-5 subtitle is-4 has-text-centered">
              No Questions Found.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </x-container>
</x-layout>
