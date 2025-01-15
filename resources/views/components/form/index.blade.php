{{--
file: resources/views/form/index.blade.php
author: Ian Kollipara
date: 2024-07-26
description: |
    This is the root of the form builder. It is responsible for rendering the form
    root element and providing details to its children. It also handles the CSRF
    token and method spoofing for non-GET requests.
 --}}

@props(['action', 'method' => 'post', 'model' => null])

@php
  $isGet = str($method)->lower()->__toString() === 'get';
@endphp

<form action="{{ $action }}"
      {{ $attributes }}
      method="{{ $isGet ? 'get' : 'post' }}">
  @unless ($isGet)
    <input name="_token"
           type="hidden"
           value="{{ csrf_token() }}"
           x-ref="csrf" />
    <input name="_method"
           type="hidden"
           value="{{ $method }}"
           x-ref="method">
  @endunless
  {{ $slot }}
</form>
