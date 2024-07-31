{{--
file: resources/views/form/input.blade.php
author: Ian Kollipara
date: 2024-07-26
description: The HTML for the input form component
 --}}

@props([
    'name',
    'label' => null,
    'id' => null,
    'type' => 'text',
    'help' => null,
    'hasAddons' => false,
    'fieldClass' => [],
    'noLabel' => false,
    'controlClass' => [],
])

@aware(['model', 'formName'])

@php
  $label ??= str($name)
      ->replace('_', ' ')
      ->replace('-', ' ')
      ->title();
  $id ??= "$formName--$name";
  $value = old($name, data_get($model, $name, $attributes->get('value')));
  $fieldClass = is_array($fieldClass) ? $fieldClass : explode(' ', $fieldClass);
  $controlClass = is_array($controlClass) ? $controlClass : explode(' ', $controlClass);
@endphp

<div @class(array_merge(['field', 'has-addons' => $hasAddons], $fieldClass))>
  @unless ($noLabel)
    <label class="label"
           for="{{ $id }}">
      {{ $label }}
    </label>
  @endunless
  <div @class(array_merge(['control'], $controlClass))>
    <input id="{{ $id }}"
           name="{{ $name }}"
           type="{{ $type }}"
           value="{{ $value }}"
           {{ $attributes->class(['input', 'is-danger' => $errors->has($name)]) }}>
    @if ($help)
      <p class="help mb-0">{{ $help }}</p>
    @endif
    @error($name)
      <p class="help is-danger">{{ $message }}</p>
    @enderror
  </div>
  @if ($hasAddons)
    {{ $slot }}
  @endif
</div>
