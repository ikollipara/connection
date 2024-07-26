{{--
file: resources/views/components/modal.blade.php
author: Ian Kollipara
date: 2024-06-17
description: The HTML for a modal component
 --}}

@props([
    'title',
    'footer' => null,
    'btnClass' => [],
    'modalBodyClass' => [],
    'btn' => 'Open Modal',
    'btnDelete' => false,
    'noDelete' => false,
])

@php
  $btnClass = is_array($btnClass) ? $btnClass : explode(' ', $btnClass);
  $modalBodyClass = is_array($modalBodyClass) ? $modalBodyClass : explode(' ', $modalBodyClass);
  $btnAsSlot = !is_string($btn);
@endphp

<span x-data="{ show: false }">
  <button
    @if ($btnAsSlot) {{ $btn->attributes->class(['button' => !$btnDelete, 'delete' => $btnDelete]) }} @else @class([
        'button' => !$btnDelete,
        'delete' => $btnDelete,
        ...$btnClass,
    ]) @endif
    x-on:click.stop="show = true" type="button">{{ $btnDelete ? '' : $btn }}</button>
  <section {{ $attributes->class(['modal']) }} x-bind:class="{ 'is-active': show }">
    <div class="modal-background" x-on:click.stop="show = false"></div>
    <article class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">{{ $title }}</p>
        @unless ($noDelete)
          <button x-on:click.stop="show = false" type="button" class="delete"></button>
        @endunless
      </header>
      <section @class(['modal-card-body', ...$modalBodyClass])>
        {{ $slot }}
      </section>
      @if ($footer)
        <footer {{ $footer->attributes->class(['modal-card-foot']) }}>
          {{ $footer }}
        </footer>
      @else
        <footer class="modal-card-foot"></footer>
      @endif
    </article>
  </section>
</span>
