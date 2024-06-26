{{--
file: resources/views/components/forms/input.blade.php
author: Ian Kollipara
date: 2024-06-13
description: This file contains the HTML for an input field.
 --}}

@props(['label', 'name', 'hasAddons' => false, 'withoutLabel' => false, 'fieldClasses' => []])

@php
  $fieldClasses = is_array($fieldClasses) ? $fieldClasses : explode(' ', $fieldClasses);
@endphp

<section @class(['field', 'has-addons' => $hasAddons, ...$fieldClasses])>
  @unless ($withoutLabel)
    <label for="{{ $name }}" class="label">{{ $label }}</label>
  @endunless
  @if ($attributes->wire('loading')->hasModifier('class'))
    <span class="control is-expanded" {{ $attributes->wire('loading') }} {{ $attributes->wire('target') }}>
      <input id="{{ $name }}" name="{{ $name }}"
        {{ $attributes->except(['wire:loading', 'wire:target'])->class(['input', 'is-danger' => $errors->has($name)]) }}>
    @else
      <span class="control is-expanded">
        <input id="{{ $name }}" name="{{ $name }}"
          {{ $attributes->class(['input', 'is-danger' => $errors->has($name)])->merge(['value' => old($name) ?? '']) }}>
        @error($name)
          <p class="help mb-0">{{ $message }}</p>
        @enderror
      </span>
  @endif
  @if ($hasAddons)
    {{ $slot }}
  @endif
</section>
