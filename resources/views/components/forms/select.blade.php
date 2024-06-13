{{--
file: resources/views/components/forms/select.blade.php
author: Ian Kollipara
date: 2024-06-13
description: This file contains the HTML for a select input.
 --}}

@props(['name', 'label' => null, 'options' => null, 'enum' => null, 'fieldClasses' => [], 'multiple' => false])

@php
  $label ??= ucwords($name);
  if (is_null($enum) and is_null($options)) {
      throw new Exception('You must provide either an options array or an enum.');
  }
  $is_enum = !is_null($enum);
  $fieldClasses = is_array($fieldClasses) ? implode(' ', $fieldClasses) : $fieldClasses;
  $selected = old($name) ?? [];
  $name = $multiple ? $name . '[]' : $name;
@endphp

<x-forms.field :label="$label" :class="$fieldClasses">
  <select {{ $attributes }} x-data="slimSelect('{{ $label }}...')" name="{{ $name }}" {{ $multiple ? 'multiple' : '' }}>
    @if ($is_enum)
      @foreach ($enum::cases() as $option)
        <option @if ($result = in_array($option->value, $selected)) selected @endif value="{{ $option->value }}">
          {{ $option->label }}
        </option>
      @endforeach
    @else
      @foreach ($options as $option)
        <option @if (in_array($option, $selected)) selected @endif value="{{ $option }}">
          {{ ucwords($option) }}
        </option>
      @endforeach
    @endif
  </select>
</x-forms.field>
