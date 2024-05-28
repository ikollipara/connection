{{--
file: resources/views/components/tabs/tab.blade.php
author: Ian Kollipara
date: 2024-05-28
description: A tab component for Blade views. Based on Bulma's tabs.
    This wraps the content of a tab.
 --}}

@aware(['tabTitles' => []])
@props(['title', 'component' => null])

@php
  $tabTitles = is_array($tabTitles) ? $tabTitles : explode(', ', $tabTitles);
  $tabIndex = array_search($title, $tabTitles);
  if ($tabIndex === false) {
      throw new Exception("Tab title '{$title}' not found in tabTitles array (" . implode(', ', $tabTitles) . ').');
  }
  $isFirst = $tabIndex === 0;
@endphp

@unless ($component)
  <article {{ $attributes->class(['is-hidden' => !$isFirst]) }}
    x-bind:class="{ 'is-hidden': tab != {{ $tabIndex }} }">
    {{ $slot }}
  </article>
@else
  <x-dynamic-component {{ $attributes->class(['is-hidden' => !$isFirst]) }} :component="$component"
    x-bind:class="{ 'is-hidden': tab != {{ $tabIndex }} }">
    {{ $slot }}
  </x-dynamic-component>
@endunless
