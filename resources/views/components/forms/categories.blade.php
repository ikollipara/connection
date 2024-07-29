@php
  use App\Enums\Category;
@endphp

<span wire:ignore>
  <select id="category"
          name="category"
          x-data="slimSelect('Categories...')"
          x-modelable="selected"
          {{ $attributes }}>
    @foreach (Category::cases() as $category)
      <option value="{{ $category }}"
              wire:key="{{ $category }}">{{ Str::of($category)->title() }}
      </option>
    @endforeach
  </select>
</span>
