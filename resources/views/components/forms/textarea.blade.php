{{--
file: resources/views/components/forms/textarea.blade.php
author: Ian Kollipara
date: 2024-05-30
description: The form textarea component. Based off of Bulma.
 --}}

@props(['name', 'label' => null])

@php
  $label = $label ?? ucwords($name);
@endphp

<x-forms.field name="{{ $name }}" label="{{ $label }}">
  <textarea {{ $attributes->class(['textarea']) }} name="{{ $name }}" id="{{ $name }}" class="textarea"
    rows="5"></textarea>
</x-forms.field>
