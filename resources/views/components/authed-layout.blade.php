{{--
file: resources/views/components/authed-layout.blade.php
author: Ian Kollipara
date: 2024-09-08
description: The layout for authenticated users.
 --}}

@props(['title' => ''])

<x-app-layout {{ $attributes }}>

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
                  class="hidden sm:inline self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">conneCTION</span>
          </a>
        </div>
        <div class="flex items-center">
          <x-form class="max-w-md mx-auto hidden md:block mb-0"
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
        </div>
      </div>
    </div>
  </nav>

  <aside class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
         id="logo-sidebar"
         aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
      <ul class="space-y-2 font-medium">
        <li>
          <a class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
             href="{{ route('search') }}">
            <x-lucide-search
                             class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
            <span class="flex-1 ms-3 whitespace-nowrap">Search</span>
          </a>
        </li>
        <li>
          <a class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
             href="{{ route('user.feed', 'me') }}">
            <x-lucide-home
                           class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
            <span class="ms-3">My Feed</span>
          </a>
        </li>
        <li>
          <button class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                  data-collapse-toggle="posts--navigation"
                  type="button"
                  aria-controls="dropdown-example">
            <x-lucide-newspaper
                                class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">My Posts</span>
            <svg class="w-3 h-3"
                 aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 10 6">
              <path stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 4 4 4-4" />
            </svg>
          </button>
          <ul class="hidden py-2 space-y-2"
              id="posts--navigation">
            <li>
              <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 href="{{ route('users.posts.index', 'me') }}?status=draft">My Drafts</a>
            </li>
            <li>
              <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 href="{{ route('users.posts.index', 'me') }}?status=published">My Published Posts</a>
            </li>
            <li>
              <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 href="{{ route('users.posts.index', 'me') }}?status=archived">My Archived Posts</a>
            </li>
            <li>
              <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 href="{{ route('users.posts.create', 'me') }}">Create a Post</a>
            </li>
          </ul>
        </li>
        <li>
          <button class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                  data-collapse-toggle="collections--navigation"
                  type="button"
                  aria-controls="collections--navigation">
            <x-lucide-layers
                             class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">My Collections</span>
            <svg class="w-3 h-3"
                 aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 10 6">
              <path stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 4 4 4-4" />
            </svg>
          </button>
          <ul class="hidden py-2 space-y-2"
              id="collections--navigation">
            <li>
              <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 href="{{ route('users.collections.index', 'me') }}?status=draft">My Drafts</a>
            </li>
            <li>
              <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 href="{{ route('users.collections.index', 'me') }}?status=published">My Published Collections</a>
            </li>
            <li>
              <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 href="{{ route('users.collections.index', 'me') }}?status=archived">My Archived Collections</a>
            </li>
            <li>
              <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 href="{{ route('users.collections.create', 'me') }}">Create a Collection</a>
            </li>
          </ul>
        </li>
        <li>
          <button class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                  data-collapse-toggle="events--navigation"
                  type="button"
                  aria-controls="events--navigation">
            <x-lucide-calendar
                               class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Events</span>
            <svg class="w-3 h-3"
                 aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 10 6">
              <path stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 1 4 4 4-4" />
            </svg>
          </button>
          <ul class="hidden py-2 space-y-2"
              id="events--navigation">
            <li>
              <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 href="{{ route('events.index') }}">Upcoming Events</a>
            </li>
            <li>
              <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 href="{{ route('events.index', 'attending') }}">Events I'm attending</a>
            </li>
            <li>
              <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 href="{{ route('users.events.index', 'me') }}">My Events</a>
            </li>
            <li>
              <a class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                 href="{{ route('users.events.create', 'me') }}">Create an Event</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </aside>

  <div class="p-4 sm:ml-64">
    <div class="p-4 mt-14">
      {{ $slot }}
    </div>
  </div>
</x-app-layout>
