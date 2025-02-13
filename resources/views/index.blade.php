{{--
file: resources/views/index.blade.php
author: Ian Kollipara
date: 2024-09-08
description: The landing page for the application
 --}}

<x-guest-layout>
  <section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
      <div class="mr-auto place-self-center lg:col-span-7">
        <h1
            class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">
          Learn about CS, together.
        </h1>
        <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
          Connect with teachers across the state about Computer Science. Learn new technologies, form new connections,
          and grow your network and ability.
        </p>
        <a class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900"
           href="{{ route('register') }}">
          Join Now
          <svg class="w-5 h-5 ml-2 -mr-1"
               fill="currentColor"
               viewBox="0 0 20 20"
               xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                  d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
          </svg>
        </a>
        <a class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800"
           href="{{ route('about') }}">
          Learn More
        </a>
      </div>
      <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
        <img src="/images/logo-text.png"
             alt="logo">
      </div>
    </div>
  </section>
  <section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
      <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-4 md:gap-12 md:space-y-0">
        @include('marketing.feature', [
            'component' => 'lucide-newspaper',
            'name' => 'Posts',
            'description' =>
                'Showcase your knowledge and ideas through a rich post system. Other teachers can comment, like, or even favorite your post.',
        ])
        @include('marketing.feature', [
            'component' => 'lucide-message-square',
            'name' => 'Comments',
            'description' =>
                'Discuss with a community of interested individuals around posts and collections. Let your voice be heard!',
        ])
        @include('marketing.feature', [
            'component' => 'lucide-layers',
            'name' => 'Collections',
            'description' =>
                'Collect posts together into something shareable. Whether it\'s for lesson planning or just to share, collections allow it all.',
        ])
        @include('marketing.feature', [
            'component' => 'lucide-calendar',
            'name' => 'Events',
            'new' => true,
            'description' =>
                'A community is more than just posts and comments. Join events to learn more about the community and the technologies that are being used.',
        ])
      </div>
    </div>
  </section>
</x-guest-layout>
