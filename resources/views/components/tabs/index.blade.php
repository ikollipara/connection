{{--
file: resources/views/components/tabs/index.blade.php
author: Ian Kollipara
date: 2024-05-28
description: A tab component for Blade views. Based on Bulma's tabs.
    This wraps the entire tabs component.
 --}}

@props(['component' => null, 'tabTitles'])

@php
  $tabTitles = is_array($tabTitles) ? $tabTitles : explode(',', $tabTitles);
@endphp

@if ($component)
  <x-dynamic-component :component="$component" {{ $attributes }} x-data="{ tab: 0 }">
    <section class="tabs is-centered">
      <ul>
        @foreach ($tabTitles as $tabTitle)
          <li x-bind:class="{ 'is-active': tab == {{ $loop->index }} }">
            <a x-on:click="tab = {{ $loop->index }}">{{ $tabTitle }}</a>
          </li>
        @endforeach
      </ul>
    </section>
    {{ $slot }}
  </x-dynamic-component>
@else
  <section {{ $attributes }} x-data="{ tab: 0 }">
    <section class="tabs is-centered">
      <ul>
        @foreach ($tabTitles as $tabTitle)
          <li x-bind:class="{ 'is-active': tab == {{ $loop->index }} }">
            <a x-on:click="tab = {{ $loop->index }}">{{ $tabTitle }}</a>
          </li>
        @endforeach
      </ul>
    </section>
    {{ $slot }}
  </section>
@endif
