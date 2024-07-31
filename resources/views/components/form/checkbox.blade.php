{{--
file: resources/views/components/form/checkbox.blade.php
author: Ian Kollipara
date: 2024-07-31
description: |
    The HTML for the checkbox form component. This element
    allows the user to select a single checkbox input. If
    the xBoolean attribute is set to true, a boolean string of
    'true' or 'false' will be returned instead of 'on' or null.
 --}}


@props([
    'name',
    'label' => null,
    'id' => null,
    'help' => null,
    'xBoolean' => false,
])


@aware(['model'])

@php
    $id ??= $name;
    $checked = old($name, data_get($model, $name, $attributes->get('checked')));
@endphp


@unless($xBoolean)
<label class="checkbox">
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}">
    {{ $label ?? $slot }}
    @if ($help)
        <p class="is-sr-only">{{ $help }}</p>
    @endif
</label>
@else
<label x-data="{ checked: {{ $checked ? 'true' : 'false' }} }" class="checkbox">
    <input type="hidden" name="{{ $name }}" x-bind:value="checked ? 'true' : 'false'">
    <input x-model="checked" type="checkbox" id="{{ $id }}">
    {{ $label ?? $slot }}
    @if ($help)
        <p class="is-sr-only">{{ $help }}</p>
    @endif
</label>
@endunless
