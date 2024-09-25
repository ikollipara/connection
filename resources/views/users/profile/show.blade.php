{{--
file: resources/views/users/profile/show.blade.php
author: Ian Kollipara
date: 2024-09-21
description: The profile page for a user
 --}}

@use('Illuminate\Support\Str')

<x-reading-layout :title="$user->full_name"
                  wrapper-class="xl:!mx-5">
  <div class="py-8 px-4 mx-auto lg:py-16">
    <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12 mb-8">
      <img class="rounded-full w-36 h-36 mx-auto"
           src="{{ $user->avatar }}"
           alt="{{ $user->full_name }}">
      <h1 class="text-gray-900 dark:text-white text-3xl md:text-5xl font-extrabold mb-2 text-center">
        {{ $user->full_name }}
      </h1>
      <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-3 text-center">
        {{ $profile->short_title }}
      </p>
      @auth
        @if (auth()->user()->isFollowing($user))
          <x-form class="w-full flex mx-auto mb-6"
                  form-name="follow"
                  method="delete"
                  action="{{ route('users.followers.destroy', [$user, auth()->user()]) }}">
            <button class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex text-center mx-auto dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-800"
                    type="submit">
              <x-lucide-user-minus class="w-5 h-5 me-2" />
              Unfollow
            </button>
          </x-form>
        @else
          <x-form class="w-full flex mx-auto mb-6"
                  form-name="follow"
                  method="post"
                  action="{{ route('users.followers.store', $user) }}">
            <input name="follower_id"
                   type="hidden"
                   value="{{ auth()->id() }}">
            <button class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex text-center mx-auto dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800"
                    type="submit">
              <x-lucide-user-plus class="w-5 h-5 me-2" />
              Follow
            </button>
          </x-form>
        @endif
      @endauth
      <ul class="flex flex-wrap items-center justify-center text-gray-900 dark:text-white">
        <li>
          <a class="me-4 hover:underline md:me-6 "
             href="#">{{ $postCount }} {{ Str::plural('Post', $postCount) }}</a>
        </li>
        <li>
          <a class="me-4 hover:underline md:me-6"
             href="#">{{ $collectionCount }} {{ Str::plural('Collection', $collectionCount) }}</a>
        </li>
        <li>
          <a class="me-4 hover:underline md:me-6 "
             href="{{ route('users.followers.index', $user) }}">{{ $followerCount }}
            {{ Str::plural('Follower', $followerCount) }} </a>
        </li>
        <li>
          <a class="me-4 hover:underline md:me-6"
             href="{{ route('users.following', $user) }}">{{ $followingCount }} Following</a>
        </li>
      </ul>

    </div>
  </div>
  <div class="px-4"
       x-data="editor({ name: 'name', readOnly: true, canUpload: true, csrf: '{{ csrf_token() }}', body: '{!! $profile->bio->toJson() !!}' })">
    <input name="name"
           type="hidden"
           x-bind="input">
    <div x-bind="editor"></div>
  </div>
</x-reading-layout>
