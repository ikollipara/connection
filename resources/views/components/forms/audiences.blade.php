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
  <select x-data="slimSelect('Audiences...')" x-modelable="selected" {{ $attributes }} name="audience" id="audience">
    @foreach (Audience::cases() as $audience)
      <option wire:key="{{ $audience->value }}" value="{{ $audience->value }}">{{ $audience->label }}</option>
    @endforeach
  </select>
</span>
