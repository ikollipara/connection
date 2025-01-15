@php
  use App\Enums\Language;
@endphp

<span wire:ignore>
  <select id="languages"
          name="languages"
          x-data="slimSelect('Languages...')"
          {{ $attributes }}>
    @foreach (Language::cases() as $language)
      <option value="{{ $language->value }}"
              wire:key='{{ $language->value }}'>{{ $language->label }}</option>
    @endforeach
  </select>
</span>
