@php
  use App\Enums\Language;
@endphp

<span wire:ignore>
  <select x-data="slimSelect('Languages...')" name="languages" id="languages" {{ $attributes }}>
    @foreach (Language::cases() as $language)
      <option wire:key='{{ $language->value }}' value="{{ $language->value }}">{{ $language->label }}</option>
    @endforeach
  </select>
</span>
