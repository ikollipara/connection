{{--
file: resources/views/components/form-select.blade.php
author: Ian Kollipara
date: 2024-09-09
description: The HTML for the select form component
 --}}

@props([
    'name',
    'id' => null,
    'selected' => [],
    'value' => null,
    'multiple' => false,
    'options' => [],
    'placeholder' => null,
])

@aware(['model', 'formName'])

@php
  use Illuminate\Support\Arr;

  $id ??= "$name--" . Str::random(8);
  $placeholder ??= ucwords($name);
  $value = old($name, $model?->getAttribute($name) ?? $value);
  $options = collect($options);
  $selected = collect(Arr::wrap($selected))->flatten()->toArray();

  $isSelected = function ($option) use ($selected) {
      foreach ($selected as $value) {
          if ($value instanceof \Spatie\Enum\Laravel\Enum) {
              if ($value->value === $option->value) {
                  return true;
              }
          } else {
              if ($value === $option->value) {
                  return true;
              }
          }
      }

      return false;
  };
@endphp

<select id="{{ $id }}"
        name="{{ $name . ($multiple ? '[]' : '') }}"
        @if ($formName) form="{{ $formName }}" @endif
        x-data="slimSelect('{{ $placeholder }}...')"
        x-on:invalid="$dispatch('invalid:{{ $name . ($multiple ? '[]' : '') }}'); $nextTick(() => $el.focus());"
        @if ($multiple) multiple @endif {{ $attributes }}>
  @foreach ($options as $option)
    <option value="{{ $option->value }}"
            @selected($isSelected($option))>
      {{ $option->label }}
    </option>
  @endforeach
</select>
