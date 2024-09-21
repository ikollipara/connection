@php
  use App\Enums\StandardGroup;
@endphp

<span wire:ignore>
  <select id="standard_groups"
          name="standard_groups"
          {{ $attributes }}
          x-data="slimSelect('Standard Groups...')">
    @foreach (StandardGroup::cases() as $group)
      <option value="{{ $group->value }}"
              wire:key="{{ $group->value }}">{{ $group->label }}</option>
    @endforeach
  </select>
</span>
