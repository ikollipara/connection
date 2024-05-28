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
