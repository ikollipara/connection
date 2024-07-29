@props(['selected' => null])
@php
  use App\Enums\Grade;
  $selected = is_array($selected) ? array_map(fn($grade) => Grade::from($grade), $selected) : [];
@endphp

<span wire:ignore>
  <select id="grades"
          name="grades"
          x-data="slimSelect('Grades...')"
          {{ $attributes }}>
    @foreach (Grade::cases() as $grade)
      <option value="{{ $grade->value }}"
              wire:key="{{ $grade->value }}"
              @if (in_array($grade, $selected)) selected @endif>
        {{ $grade->label }}</option>
    @endforeach
  </select>
</span>
