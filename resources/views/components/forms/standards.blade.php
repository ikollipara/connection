@php
  use App\Enums\Standard;
@endphp

<span wire:ignore>
  <select x-data="slimSelect('Standards...')" {{ $attributes }} name="standards" id="standards">
    @foreach (Standard::cases() as $standard)
      <option wire:key="{{ $standard->value }}" value="{{ $standard->value }}">{{ $standard->label }}</option>
    @endforeach
  </select>
</span>
