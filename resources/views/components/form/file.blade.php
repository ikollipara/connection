{{--
file: resource/views/components/form/file.blade.php
author: Ian Kollipara
date: 2024-07-31
description: |
    A file input element for the form builder. This component features
    progressive enhancement through Filepond, a JavaScript library that
    provides a file input element with a modern design and additional
    features like drag-and-drop file uploads and image previews.

    This component is designed to be used with the form builder component
    and should not be used on its own.
 --}}

@props(['name', 'label' => null, 'id' => null, 'fieldClass' => [], 'controlClass' => [], 'help' => null])

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

<div @class($fieldClass)>
  <label class="label"
         for="{{ $id }}">
    {{ $label }}
  </label>
  <div @class($controlClass)>
    <noscript>
      <div class="file is-boxed">
        <label class="file-label">
          <input name="{{ $name }}"
                 type="file"
                 value="{{ $value }}"
                 {{ $attributes->class(['file-input']) }}>
          <span class="file-cta">
            <span class="file-icon">
              <x-lucide-upload width="50"
                               height="50" />
            </span>
          </span>
          <span class="file-label">Choose a file...</span>
        </label>
      </div>
    </noscript>
    <input id="{{ $id }}"
           name="{{ $name }}"
           type="file"
           value="{{ $value }}"
           x-data="filepond()">
  </div>
  @if ($help)
    <p class="is-sr-only">{{ $help }}</p>
  @endif
</div>
