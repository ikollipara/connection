{{--
file: resources/views/components/table.blade.php
author: Ian Kollipara
date: 2024-06-17
description: The HTML for a table component
 --}}

@props([
    'rowComponent' => null,
    'headers' => [],
    'header' => null,
    'items' => null,
    'fullWidth' => true,
    'empty' => null,
])

@php
  $headers = is_array($headers) ? $headers : explode(', ', $headers);
  $has_headers = count($headers) > 0;
  $has_items = !is_null($items);
@endphp

<table {{ $attributes->class(['table', 'is-fullwidth' => $fullWidth]) }}>
  @if ($header)
    {{ $header }}
  @elseif ($has_headers)
    <thead>
      <tr>
        @foreach ($headers as $header)
          <th>{{ $header }}</th>
        @endforeach
      </tr>
    </thead>
  @endif
  <tbody>
    @if ($has_items and $rowComponent)
      @forelse ($items as $item)
        @if ($rowComponent)
          <x-dynamic-component :component="$rowComponent" :item="$item" />
        @endif
      @empty
        {{ $empty }}
      @endforelse
    @else
      {{ $slot }}
    @endif
  </tbody>
</table>
