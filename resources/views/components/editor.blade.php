{{-- @props(['name', 'readOnly' => false, 'cannotUpload' => false, 'xModel' => null])
@if ($attributes->wire('model')->value)
  <span x-data="{ body: @entangle($attributes->wire('model')) }">
    <article @@editor-saved.document="persistDeletedImages" wire:ignore class="content is-medium editor"
      {{ $attributes->except('wire:model') }} x-data="editor(@js($readOnly), @js($cannotUpload), '{{ csrf_token() }}', JSON.parse(body))">
    </article>
  </span>
@else
  <span x-data="{ body: {{ $xModel }} }">
    <article @@editor-saved.document="persistDeletedImages" wire:ignore class="content is-medium editor"
      {{ $attributes }} x-data="editor(@js($readOnly), @js($cannotUpload), '{{ csrf_token() }}', body)">
    </article>
  </span>
@endif --}}

{{--
file: resources/views/components/editor.blade.php
author: Ian Kollipara
date: 2024-06-06
description: This file contains the HTML for the editor component.
The editor component is a WYSIWYG editor that uses the EditorJS editor.
 --}}

@props(['name', 'readOnly' => false, 'canUpload' => true, 'xModel' => null, 'value' => null])

@php
  $has_wire = (bool) $attributes->wire('model')->value;
@endphp

<section {{ $attributes }} x-data="editor({
    name: @js($name),
    readOnly: @js($readOnly),
    csrf: '{{ csrf_token() }}',
    @if ($value) body: {{ $value }} @endif
    @if ($has_wire) body: $wire.{{ $attributes->wire('model')->value }} @endif
})" x-modelable="body"
  @if ($xModel) x-model="{{ $xModel }}" @endif>
  <input x-bind="input" hidden>
  <div wire:ignore x-bind="editor"></div>
</section>
