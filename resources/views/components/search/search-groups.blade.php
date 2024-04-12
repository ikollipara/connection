@php
  use App\Enums\Standard;
@endphp

<span wire:ignore>
  <select {{ $attributes }} x-data="slimSelect('Standard Groups...')" name="standard_groups" id="standard_groups">
    @foreach (Standard::groups() as $group)
      <option wire:key="{{ $group }}" value="{{ $group }}">{{ $group }}</option>
    @endforeach
  </select>
</span>
