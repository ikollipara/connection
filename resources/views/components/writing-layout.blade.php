{{--
file: resources/views/components/writing-layout.blade.php
author: Ian Kollipara
date: 2024-09-09
description: The layout for writing posts & collections
 --}}

@props(['title' => '', 'drawerName', 'showSave' => false])

@php
  $resourceType = str(request()->route()->getName())
      ->after('users.')
      ->before('.');
  $resourceTypeSingular = match ($resourceType->__toString()) {
      'posts' => 'post',
      'collections' => 'collection',
  };
@endphp

<x-app-layout :title="$title"
              x-data
              x-on:editor:unsaved.debounce.window="$dispatch('save')">
  <nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <a class="flex items-center space-x-3 rtl:space-x-reverse"
         href="{{ route('user.feed', 'me') }}">
        <img class="h-12"
             src="/images/logo.png"
             alt="conneCTION Logo" />
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">conneCTION</span>
      </a>
      <button class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
              data-collapse-toggle="navbar-default"
              type="button"
              aria-controls="navbar-default"
              aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5"
             aria-hidden="true"
             xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 17 14">
          <path stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>
      <div class="hidden w-full md:block md:w-auto"
           id="navbar-default">
        <ul
            class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700 items-center">
          <li>
            <p class='block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0 dark:text-white text-xs'
               x-data="{ unsaved: false, saving: false }"
               x-on:editor:unsaved.window="unsaved = true"
               x-on:editor:saved.window="unsaved = false; saving = false; document.querySelector('#drawer-btn').disabled = false;"
               x-on:editor:saving.window="saving = true; document.querySelector('#drawer-btn').disabled = true"
               x-bind:class="{ 'text-red-700': unsaved, 'text-green-700': !unsaved, 'text-yellow-700': saving }"
               x-text="unsaved ? 'Unsaved' : saving ? 'Saving...' : 'Saved'">
            </p>
          </li>
          @if (request()->route()->parameter($resourceTypeSingular))
            <li>
              <button class='block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent'
                      id="drawer-btn"
                      data-drawer-target="{{ $drawerName }}"
                      data-drawer-show="{{ $drawerName }}"
                      aria-controls="{{ $drawerName }}">
                {{ $drawerTitle ?? 'Publish' }}
              </button>
            </li>
          @endif
          @if ($showSave)
            <li>
              <button class='block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent'
                      x-data
                      x-on:click="$dispatch('manual-save')">
                Save
              </button>
            </li>
          @endif
          <li>
            <a class='block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent'
               href="{{ route("users.$resourceType.index", 'me') }}">Back</a>
          </li>
          <li>
            <div class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
              <img class="w-8 h-8 rounded-full"
                   src="{{ auth()->user()->avatar }}"
                   alt="user photo">
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="bg-white dark:bg-gray-900">
    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
      @session('published')
        @if (session('published'))
          <div class="bg-green-100 border-l-4 border-green-500 p-4 mb-4">
            <p class="text-green-700 font-semibold">Published!</p>
          </div>
        @else
          <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-4">
            <p class="text-red-700 font-semibold">Error!</p>
            <p class="text-red-600">Unable to be published, please try again later.</p>
          </div>
        @endif
      @endsession
      @session('saved')
        @if (session('saved'))
          <div class="bg-green-100 border-l-4 border-green-500 p-4 mb-4">
            <p class="text-green-700 font-semibold">Saved!</p>
          </div>
        @else
          <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-4">
            <p class="text-red-700 font-semibold">Error! Please try again later.</p>
          </div>
        @endif
      @endsession
      {{ $slot }}
    </div>
  </section>
</x-app-layout>
