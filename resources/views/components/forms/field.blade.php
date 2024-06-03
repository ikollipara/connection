{{--
file: resources/views/components/forms/field.blade.php
author: Ian Kollipara
date: 2024-05-30
description: The form field component. Based off of Bulma.
 --}}

@props(['name' => '', 'label' => null, 'isExpanded' => false, 'empty' => false])

@php
  $label = $label ?? ucwords($name);
@endphp

<section {{ $attributes->class(['field']) }}>
    @if ($empty)
        {{{ $slot }}}
    @else
  <div @class(['control', 'is-expanded' => $isExpanded])>
    <label for="{{ $name }}" class="label">{{ $label }}</label>
    {{ $slot }}
  </div>
    @endif
</section>
