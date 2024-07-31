{{--
file: resources/views/components/forms/textarea.blade.php
author: Ian Kollipara
date: 2024-07-31
description: |
    The form textarea component. This component wraps both the
    textarea element as well as our rich text editor. This allows
    for progressive enhancement.
 --}}

@props([
    'name',
    'label' => null,
    'id' => null,
    'help' => null,
    'rich' => false,
    'fieldClass' => [],
    'controlClass' => [],
])

@aware(['model', 'formName'])

@php
  $label ??= str($name)
      ->replace('_', ' ')
      ->replace('-', ' ')
      ->title();
  $id = "{$formName}--{$name}";
  $value = old($name, data_get($model, $name, $attributes->get('value')));
  $fieldClass = is_array($fieldClass) ? $fieldClass : explode(' ', $fieldClass);
  $controlClass = is_array($controlClass) ? $controlClass : explode(' ', $controlClass);
@endphp

<div @class(array_merge(['field'], $fieldClass))>
  <label class="label"
         for="{{ $id }}">
    {{ $label }}
  </label>
  <div @class(array_merge(['control'], $controlClass))>
    @if ($rich)
      <noscript>
        <textarea id="{{ $id }}"
                  name="{{ $name }}"
                  {{ $attributes->class(['textarea'])->merge(['rows' => 5]) }}>
        {{ $value }}
        </textarea>
      </noscript>
      <x-editor :name="$name"
                :value="$value"
                :form="$formName" />
    @else
      <textarea id="{{ $id }}"
                name="{{ $name }}"
                {{ $attributes->class(['textarea'])->merge(['rows' => 5]) }}>
        {{ $value }}
      </textarea>
    @endif
    @if ($help)
      <p class="help mb-0">{{ $help }}</p>
    @endif
    @error($name)
      <p class="help is-danger">{{ $message }}</p>
    @enderror
  </div>
