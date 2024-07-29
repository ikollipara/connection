@php
  use App\Enums\Practice;
@endphp

<span wire:ignore>
  <select id="practice"
          name="practice"
          x-data="slimSelect('Practices...')"
          x-modelable="selected"
          {{ $attributes }}>
    @foreach (Practice::cases() as $practice)
      <option value="{{ $practice }}"
              wire:key="{{ $practice }}">{{ $practice }}</option>
    @endforeach
  </select>
</span>
