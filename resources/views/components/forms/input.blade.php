@props(['label', 'name', 'hasAddons' => false, 'withoutLabel' => false, 'fieldClasses' => []])

@php
  $fieldClasses = is_array($fieldClasses) ? $fieldClasses : explode(' ', $fieldClasses);
@endphp

<section @class(['field', 'has-addons' => $hasAddons, ...$fieldClasses])>
  @unless ($withoutLabel)
    <label for="{{ $name }}" class="label">{{ $label }}</label>
  @endunless
  @if ($attributes->wire('loading')->hasModifier('class'))
    <span class="control is-expanded" {{ $attributes->wire('loading') }} {{ $attributes->wire('target') }}>
      <input id="{{ $name }}" name="{{ $name }}"
        {{ $attributes->except(['wire:loading', 'wire:target'])->class(['input', 'is-danger' => $errors->has($name)]) }}>
    @else
      <span class="control is-expanded">
        <input id="{{ $name }}" name="{{ $name }}"
          {{ $attributes->class(['input', 'is-danger' => $errors->has($name)])->merge(['value' => old($name) ?? '']) }}>
      </span>
  @endif
  @error($name)
    <p class="help is-danger">{{ $message }}</p>
  @enderror
  @if ($hasAddons)
    {{ $slot }}
  @endif
</section>
