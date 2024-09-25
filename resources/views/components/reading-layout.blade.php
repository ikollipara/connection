{{--
file: resources/views/components/reading-layout.blade.php
author: Ian Kollipara
date: 2024-09-16
description: The layout for reading pages
 --}}

@props(['post', 'title', 'aside' => null, 'wrapperClass' => ''])

<x-app-layout :title="$title"
              x-data>
  <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start rtl:justify-end">
          <button class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                  data-drawer-target="logo-sidebar"
                  data-drawer-toggle="logo-sidebar"
                  type="button"
                  aria-controls="logo-sidebar">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6"
                 aria-hidden="true"
                 fill="currentColor"
                 viewBox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">
              <path clip-rule="evenodd"
                    fill-rule="evenodd"
                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
              </path>
            </svg>
          </button>
          <a class="flex ms-2 md:me-24"
             href="{{ route('user.feed', 'me') }}">
            <img class="h-8 me-3"
                 src="/images/logo.png"
                 alt="">
            <span
                  class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">conneCTION</span>
          </a>
        </div>
        <div class="flex items-center gap-x-3">
          <div>
            @auth
              <a class='block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent'
                 href="{{ route('user.feed', 'me') }}">Back</a>
            @endauth
            @guest
              <a class='block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent'
                 href="{{ route('login') }}">Sign Up!</a>
            @endguest
          </div>
          <x-form class="max-w-md mx-auto hidden md:block mb-0"
                  form-name="search"
                  x-data
                  action="{{ route('search') }}"
                  method="get">
            <label class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
                   for="default-search">Search</label>
            <div class="relative">
              <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <x-lucide-search class="w-4 h-4 text-gray-500 dark:text-gray-400" />
              </div>
              <input name="type"
                     type="hidden"
                     value="{{ request('type', 'post') }}">
              <input class="block w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                     id="default-search"
                     name="q"
                     type="search"
                     x-on:keydown.enter.prevent="$root.submit()"
                     placeholder="Search..."
                     required />
            </div>
          </x-form>
          @auth
            <div class="flex items-center ms-3">
              <div>
                <button class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        data-dropdown-toggle="dropdown-user"
                        type="button"
                        aria-expanded="false">
                  <span class="sr-only">Open user menu</span>
                  <img class="w-8 h-8 rounded-full"
                       src="{{ auth()->user()->avatar }}"
                       alt="user photo">
                </button>
              </div>
              <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                   id="dropdown-user">
                <div class="px-4 py-3"
                     role="none">
                  <p class="text-sm text-gray-900 dark:text-white"
                     role="none">
                    {{ auth()->user()->full_name }}
                  </p>
                  <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300"
                     role="none">
                    {{ auth()->user()->email }}
                  </p>
                </div>
                <ul class="py-1"
                    role="none">
                  <li>
                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                       href="{{ route('users.profile.edit', 'me') }}"
                       role="menuitem">Edit Profile</a>
                  </li>
                  {{-- <li>
                    <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                       href="#"
                       role="menuitem">Settings</a>
                  </li> --}}
                  <li>
                    <form class="flex"
                          action="{{ route('logout') }}"
                          method="post">
                      @csrf
                      @method('DELETE')
                      <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white w-full text-left"
                              type="submit"
                              role="menuitem">Sign out</button>
                    </form>
                  </li>
                </ul>
              </div>
            </div>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  @if ($aside)
    {{ $aside }}
  @endif
  <div @class(['p-4 sm:ml-64 xl:mx-[33vw]', $wrapperClass])>
    <div class="p-4 mt-14">
      {{ $slot }}
    </div>
  </div>
</x-app-layout>
