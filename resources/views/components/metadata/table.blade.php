{{--
file: resources/views/components/metadata/table.blade.php
author: Ian Kollipara
date: 2024-05-30
description: The table display for the metadata
 --}}

@props(['metadata'])

@php
  $metadataArray = [];
  foreach ($metadata as $property => $value) {
      if ($property === 'category' || $property === 'audience') {
          $metadataArray[ucwords($property)] = [$value->label];
      } else {
          if ($value->count() > 0) {
              $metadataArray[ucwords($property)] = $value->map(fn($item) => $item->label)->toArray();
          }
      }
  }
@endphp

<section {{ $attributes->class(['table-container']) }}>
  <table class="table is-fullwidth">
    <thead>
      <tr>
        <th>Metadata</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($metadataArray as $property => $values)
        <tr>
          <td>{{ $property }}</td>
          <td class="level">
            <div class="level-left">
              @foreach ($values as $value)
                <span class="tag">{{ $value }}</span>
              @endforeach
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</section>
