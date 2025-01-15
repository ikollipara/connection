{{--
file: resources/views/components/forms/audiences.blade.php
author: Ian Kollipara
date: 2024-06-13
description: This file contains the HTML for a select input for audiences.
 --}}

@php
  use App\Enums\Audience;
@endphp

<span wire:ignore>
  <select id="audience"
          name="audience"
          x-data="slimSelect('Audiences...')"
          x-modelable="selected"
          {{ $attributes }}>
    @foreach (Audience::cases() as $audience)
      <option value="{{ $audience->value }}"
              wire:key="{{ $audience->value }}">{{ $audience->label }}</option>
    @endforeach
  </select>
</span>
