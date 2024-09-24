{{--
file: resources/views/search/index.blade.php
author: Ian Kollipara
date: 2024-09-23
description: The search form for the entire site
 --}}

<x-reading-layout title="Search"
                  wrapper-class="sm:!ml-64 sm:!mx-5">
  <x-slot:aside>
    @include('search.partials.filters', ['formName' => 'search'])
  </x-slot>
  <x-title label="Search" />
  <x-form form-name="search"
          method="GET"
          action="{{ route('search') }}">
    <div class="flex">
      <x-form-input class="rounded-e-none"
                    name="q"
                    form-name="search"
                    type="search"
                    value="{{ request('q', '') }}"
                    placeholder="Search" />
      <x-form-submit class="rounded-s-none"
                     label="Search" />
    </div>
  </x-form>
  @include('search.partials.results', ['results' => $results])
</x-reading-layout>
