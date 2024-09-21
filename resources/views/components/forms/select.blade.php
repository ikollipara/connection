{{--
file: resources/views/components/forms/select.blade.php
author: Ian Kollipara
date: 2024-06-13
description: This file contains the HTML for a select input.
 --}}

@props([
    'name',
    'label' => null,
    'options' => null,
    'enum' => null,
    'fieldClasses' => [],
    'multiple' => false,
    'selected' => [],
])

@php
  $label ??= ucwords($name);
  if (is_null($enum) and is_null($options)) {
      throw new Exception('You must provide either an options array or an enum.');
  }
  $is_enum = !is_null($enum);
  $fieldClasses = is_array($fieldClasses) ? implode(' ', $fieldClasses) : $fieldClasses;
  $selected = old($name) ?? $selected;
  $selected = is_array($selected) ? $selected : [$selected];
  $name = $multiple ? $name . '[]' : $name;
@endphp

@push('styles')
  <link href="{{ mix('css/slim-select.css') }}"
        rel="stylesheet">
@endpush

<x-forms.field :label="$label"
               :class="$fieldClasses">
  <select name="{{ $name }}"
          {{ $attributes }}
          x-data="slimSelect('{{ $label }}...')"
          {{ $multiple ? 'multiple' : '' }}>
    @if ($is_enum)
      @foreach ($enum::cases() as $option)
        <option value="{{ $option->value }}"
                @if ($result = in_array($option->value, $selected)) selected @endif>
          {{ $option->label }}
        </option>
      @endforeach
    @else
      @foreach ($options as $option)
        <option value="{{ $option }}"
                @if (in_array($option, $selected)) selected @endif>
          {{ ucwords($option) }}
        </option>
      @endforeach
    @endif
  </select>
</x-forms.field>
