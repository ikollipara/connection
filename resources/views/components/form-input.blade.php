{{--
file: resources/views/components/form-input.blade.php
author: Ian Kollipara
date: 2024-09-08
description: The HTML for the input form component
 --}}

@props(['name', 'id' => null, 'type' => 'text', 'value' => null])

@aware(['model', 'formName'])

@php
  $id ??= "$name--" . Str::random(8);
  $value ??= old($name, $model?->getAttribute($name, ''));
@endphp

<input id="{{ $id }}"
       name="{{ $name }}"
       type="{{ $type }}"
       value="{{ $value }}"
       @isset($formName) form="{{ $formName }}" @endisset
       {{ $attributes->class(['bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'])->merge(['x-data' => '', 'x-on:invalid' => '$dispatch("invalid' . $name . '"); $nextTick(() => $el.focus());']) }}>
