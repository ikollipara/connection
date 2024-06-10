@props(['selected' => null])
@php
  use App\Enums\Grade;
  $selected = is_array($selected) ? array_map(fn($grade) => Grade::from($grade), $selected) : [];
@endphp

<span wire:ignore>
  <select x-data="slimSelect('Grades...')" {{ $attributes }} name="grades" id="grades">
    @foreach (Grade::cases() as $grade)
      <option wire:key="{{ $grade->value }}" value="{{ $grade->value }}"
        @if (in_array($grade, $selected)) selected @endif>
        {{ $grade->label }}</option>
    @endforeach
  </select>
</span>
