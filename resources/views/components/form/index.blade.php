{{--
file: resources/views/form/index.blade.php
author: Ian Kollipara
date: 2024-07-26
description: |
    This is the root of the form builder. It is responsible for rendering the form
    root element and providing details to its children.
 --}}

@props(['formName', 'action', 'method' => 'post', 'model' => null])

@php
  $isGet = str($method)->lower() === 'get';
@endphp

<form id="{{ $formName }}"
      action="{{ $action }}"
      {{ $attributes->class(['tw-flex', 'tw-flex-col', 'tw-gap-1']) }}
      method="{{ $isGet ? 'get' : 'post' }}">
  @csrf
  @unless ($isGet)
    @method($method)
  @endunless
  {{ $slot }}
</form>
