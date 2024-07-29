{{--
file: resources/views/components/editor.blade.php
author: Ian Kollipara
date: 2024-06-06
description: This file contains the HTML for the editor component.
The editor component is a WYSIWYG editor that uses the EditorJS editor.
 --}}

@props(['name', 'readOnly' => false, 'canUpload' => true, 'xModel' => null, 'value' => null, 'form' => null])

@php
  $has_wire = (bool) $attributes->wire('model')->value;
@endphp

<section {{ $attributes }}
         x-data="editor({
             name: @js($name),
             readOnly: @js($readOnly),
             csrf: '{{ csrf_token() }}',
             @if ($value) body: {{ $value }} @endif
             @if ($has_wire) body: $wire.{{ $attributes->wire('model')->value }} @endif
         })"
         x-modelable="body"
         @if ($xModel) x-model="{{ $xModel }}" @endif>
  <input x-bind="input"
         hidden
         @if ($form) form="{{ $form }}" @endif>
  <div wire:ignore
       x-on:turbo:before-cache="destroy"
       x-bind="editor"></div>
</section>
