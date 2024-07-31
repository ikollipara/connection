{{--
file: resources/views/components/form/select.blade.php
author: Ian Kollipara
date: 2024-07-31
description: |
    The HTML for the select form component. This element
    makes use of Slim Select for a more user-friendly select input.
    It also handles select multiple inputs.

    The component allows the use of a custom search function to enable
    dynamic filtering of the select options.

    To set the options for the select input, pass an array of options with
    the format of ['value' => 'label'], otherwise you can simply provide the
    options as a slot.

    This element will fire the following events for interested parties:
    - name:error: when the select input has an error. Contains the error message.
    - name:change: when the select input changes. Contains the new value.
 --}}

@props([
    'name',
    'label' => null,
    'id' => null,
    'help' => null,
    'placeholder' => null,
    'fieldClass' => [],
    'controlClass' => [],
    'multiple' => false,
    'xSearch' => null,
    'xSettings' => [],
    'noLabel' => false,
    'options' => [],
])

@aware(['model', 'formName'])

@php
  $label ??= str($name)
      ->replace('_', ' ')
      ->replace('-', ' ')
      ->title();
  $id ??= "$formName--$name";
  $fieldClass = is_array($fieldClass) ? $fieldClass : explode(' ', $fieldClass);
  $controlClass = is_array($controlClass) ? $controlClass : explode(' ', $controlClass);
  $selected = old($name, data_get($model, $name, $attributes->get('selected')));
@endphp

<div @class(array_merge(['field'], $fieldClass))>
  @unless ($noLabel)
    <label class="label"
           for="{{ $id }}">
      {{ $label }}
    </label>
  @endunless
  <div @class(array_merge(['control'], $controlClass))>
    <select id="{{ $id }}"
            name="{{ $multiple ? "$name[]" : $name }}"
            @if($multiple) multiple @endif
            {{ $attributes->class(['input', 'is-danger' => $errors->has($name)]) }}
            x-data="slimSelect('{{ $placeholder ?? $label }}', '{{ $name }}', {{ json_encode($xSettings) }}, {!! $xSearch !!})">
      @if (empty($options))
        {{ $slot }}
      @else
        @foreach ($options as $value => $option)
          <option value="{{ $value }}"
                  @if ($multiple and in_array($value, $selected)) selected @endif>
            {{ $option }}
          </option>
        @endforeach
      @endif
    </select>
    @if ($help)
        <p class="help mb-0">{{ $help }}</p>
    @endif
    @error($name)
      <p class="help is-danger">{{ $message }}</p>
    @enderror
  </div>
</div>
