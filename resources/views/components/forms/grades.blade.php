@php
  use App\Enums\Grade;
@endphp

<span wire:ignore>
  <select x-data="slimSelect('Grades...')" {{ $attributes }} name="grades" id="grades">
    @foreach (Grade::cases() as $grade)
      <option wire:key="{{ $grade->value }}" value="{{ $grade->value }}">{{ $grade->label }}</option>
    @endforeach
  </select>
</span>
