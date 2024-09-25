{{--
file: resources/views/components/form-rich-text.blade.php
author: Ian Kollipara
date: 2024-09-09
description: The HTML for the rich text form component
 --}}

@props(['name', 'cannotUpload' => false, 'value' => null])

@aware(['model', 'formName'])

@php
  $value ??= Js::from(['blocks' => []]);
  $old = old($name);
  if ($old) {
      $value = Js::from($old);
  } elseif ($model?->getAttribute($name)) {
      $value = Js::from($model?->getAttribute($name));
  } else {
      $value = Js::from($value);
  }
@endphp

<script>
  window.body = JSON.stringify({{ $value }});
</script>
<div {{ $attributes }}
     x-modelable="body"
     x-data="editor({ name: @js($name), readOnly: false, canUpload: @js(!$cannotUpload), csrf: '{{ csrf_token() }}', body: window.body })">
  <input name="{{ $name }}"
         type="hidden"
         x-bind="input">
  <div x-bind="editor"></div>
</div>
