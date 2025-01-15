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

<x-layout :title="$title"
          no-livewire>
  <form class="hero is-primary"
        x-data
        action="{{ url()->current() }}"
        method="get">
    <div class="hero-body">
      <x-forms.input name="q"
                     value="{{ $has_search ? request('q') : '' }}"
                     tabindex="0"
                     x-on:change.debounce.200ms="$root.submit()"
                     placeholder="Search..."
                     without-label
                     has-addons>
        <div class="control">
          <a class="button is-dark"
             href="{{ route('faq.create') }}">Create Question</a>
        </div>
      </x-forms.input>
    </div>
  </form>
  <x-container class="mt-5"
               is-fluid>
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
              <a class="link"
                 href="{{ route('faq.show', $question) }}">Visit</a>
            </td>
          </tr>
        @empty
          <tr>
            <td class="mt-5 mx-5 subtitle is-4 has-text-centered"
                colspan="4">
              No Questions Found.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </x-container>
</x-layout>
