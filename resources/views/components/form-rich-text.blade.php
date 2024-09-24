{{--
file: resources/views/components/form-rich-text.blade.php
author: Ian Kollipara
date: 2024-09-09
description: The HTML for the rich text form component
 --}}

@props(['name', 'cannotUpload' => false, 'value' => '{"blocks": []}'])

@aware(['model', 'formName'])

@php
  $value = old($name, $model?->getAttribute($name)?->toJson() ?? $value);
@endphp

<div {{ $attributes }}
     x-modelable="body"
     x-data="editor({ name: @js($name), readOnly: false, canUpload: @js(!$cannotUpload), csrf: '{{ csrf_token() }}', body: '{{ $value }}' })">
  <input name="{{ $name }}"
         type="hidden"
         x-bind="input">
  <div x-bind="editor"></div>
</div>
