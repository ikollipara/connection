{{--
file: resources/views/components/guest-layout.blade.php
author: Ian Kollipara
date: 2024-09-08
description: The layout for guest users
 --}}

@props(['title' => ''])

<x-app-layout title="{{ $title }}"
              {{ $attributes }}>

  <nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <a class="flex items-center space-x-3 rtl:space-x-reverse"
         href="/">
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
            class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
          <li>
            <a href="{{ route('index') }}"
               @if (request()->routeIs('index')) aria-current="page" @endif
               @class([
                   'block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500' => request()->routeIs(
                       'index'),
                   'block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' => !request()->routeIs(
                       'index'),
               ])>
              Home
            </a>
          </li>
          <li>
            <a href="{{ route('about') }}"
               @if (request()->routeIs('about')) aria-current="page" @endif
               @class([
                   'block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500' => request()->routeIs(
                       'about'),
                   'block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' => !request()->routeIs(
                       'about'),
               ])>
              About
            </a>
          </li>
          <li>
            <a href="{{ route('contact') }}"
               @if (request()->routeIs('contact')) aria-current="page" @endif
               @class([
                   'block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500' => request()->routeIs(
                       'contact'),
                   'block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' => !request()->routeIs(
                       'contact'),
               ])>
              Contact
            </a>
          </li>
          <li>
            <a href="{{ route('register') }}"
               @class([
                   'block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500' => request()->routeIs(
                       'register'),
                   'block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' => !request()->routeIs(
                       'register'),
               ])
               @if (request()->routeIs('register')) aria-current="page" @endif>
              Sign Up
            </a>
          </li>
          <li>
            <a href="{{ route('login') }}"
               @if (request()->routeIs('login')) aria-current="page" @endif
               @class([
                   'block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500' => request()->routeIs(
                       'login'),
                   'block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent' => !request()->routeIs(
                       'login'),
               ])>
              Login
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  {{ $slot }}
  <footer class="p-4 bg-white md:p-8 lg:p-10 dark:bg-gray-800">
    <div class="mx-auto max-w-screen-xl text-center">
      <a class="flex justify-center items-center text-2xl font-semibold text-gray-900 dark:text-white"
         href="#">
        <img class="mr-2 h-12"
             src="/images/logo.png"
             alt="">
        conneCTION
      </a>
      <p class="my-6 text-gray-500 dark:text-gray-400">
        Learn about CS, together.
      </p>
      <ul class="flex flex-wrap justify-center items-center mb-6 text-gray-900 dark:text-white">
        <li>
          <a class="mr-4 hover:underline md:mr-6 "
             href="{{ route('about') }}">About</a>
        </li>
        <li>
          <a class="mr-4 hover:underline md:mr-6"
             href="{{ route('contact') }}">Contact</a>
        </li>
        <li>
          <a class="mr-4 hover:underline md:mr-6 "
             href="#">Sign Up</a>
        </li>
        <li>
          <a class="mr-4 hover:underline md:mr-6"
             href="{{ route('login') }}">Login</a>
        </li>
      </ul>
      <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023-2024 <a class="hover:underline"
           href="#">conneCTION™</a>. All Rights Reserved.</span>
    </div>
  </footer>
</x-app-layout>
