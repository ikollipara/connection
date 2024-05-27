@php
  use App\Enums\StandardGroup;
@endphp

<span wire:ignore>
  <select {{ $attributes }} x-data="slimSelect('Standard Groups...')" name="standard_groups" id="standard_groups">
    @foreach (StandardGroup::cases() as $group)
      <option wire:key="{{ $group->value }}" value="{{ $group->value }}">{{ $group->label }}</option>
    @endforeach
  </select>
</span>
