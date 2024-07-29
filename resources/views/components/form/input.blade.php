{{--
file: resources/views/form/input.blade.php
author: Ian Kollipara
date: 2024-07-26
description: The HTML for the input form component
 --}}

@props(['name', 'label' => null, 'id' => null, 'type' => 'text', 'help' => null])

@aware(['model', 'formName'])

@php
  $label ??= str($name)
      ->replace('_', ' ')
      ->replace('-', ' ')
      ->title();
  $id ??= "$formName--$name";
  $value = old($name, data_get($model, $name, $attributes->get('value')));
@endphp

<div class="tw-flex tw-flex-col tw-gap-1">
  <label class="tw-text-lg"
         for="{{ $id }}">{{ $label }}</label>
  <input id="{{ $id }}"
         name="{{ $name }}"
         type="{{ $type }}"
         value="{{ $value }}"
         {{ $attributes->class(['tw-px-2 tw-py-1 tw-rounded tw-border-gray-300 tw-border tw-border-solid focus:tw-outline-gray-400 tw-text-gray-800 focus:tw-ring-2 focus:tw-ring-gray-500/40']) }}>
  @if ($help)
    <p>{{ $help }}</p>
  @endif
  @error($name)
    <p>{{ $message }}</p>
  @enderror
</div>
