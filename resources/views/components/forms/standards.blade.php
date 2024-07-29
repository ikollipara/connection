@php
  use App\Enums\Standard;
@endphp

<span wire:ignore>
  <select id="standards"
          name="standards"
          x-data="slimSelect('Standards...')"
          {{ $attributes }}>
    @foreach (Standard::cases() as $standard)
      <option value="{{ $standard->value }}"
              wire:key="{{ $standard->value }}">{{ $standard->label }}</option>
    @endforeach
  </select>
</span>
