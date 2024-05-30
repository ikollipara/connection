{{--
file: resources/views/components/metadata/form.blade.php
author: Ian Kollipara
date: 2024-05-30
description: The form for setting metadata
 --}}

@props(['metadata', 'component' => null, 'metadataName' => 'metadata_form'])

@php
  use App\Enums\Grade;
  use App\Enums\Language;
  use App\Enums\Practice;
  use App\Enums\Standard;
  use App\Enums\Category;
  use App\Enums\Audience;
@endphp

@unless ($component)
  <section {{ $attributes }}>
    <x-forms.field label="Grades" name="grades" is-expanded>
      <x-forms.grades multiple wire:model.defer='{{ $metadataName }}.grades' />
    </x-forms.field>
    <x-forms.field label="Standards" name="standards" is-expanded>
      <x-forms.standards multiple wire:model.defer='{{ $metadataName }}.standards' />
    </x-forms.field>
    <x-forms.field label="Practices" name="practices" is-expanded>
      <x-forms.practices multiple wire:model.defer='{{ $metadataName }}.practices' />
    </x-forms.field>
    <x-forms.field label="Programming Languages" name="languages" is-expanded>
      <x-forms.languages multiple wire:model.defer='{{ $metadataName }}.languages' />
    </x-forms.field>
    <x-forms.field label="Category" name="category" is-expanded>
      <x-forms.categories wire:model.defer='{{ $metadataName }}.category' />
    </x-forms.field>
    <x-forms.field label="Audience" name="audience" is-expanded>
      <x-forms.audiences wire:model.defer='{{ $metadataName }}.audience' />
    </x-forms.field>
  </section>
@else
  <x-dynamic-component :component="$component" {{ $attributes }}>
    <x-forms.field label="Grades" name="grades" is-expanded>
      <x-forms.grades multiple wire:model.defer='{{ $metadataName }}.grades' />
    </x-forms.field>
    <x-forms.field label="Standards" name="standards" is-expanded>
      <x-forms.standards multiple wire:model.defer='{{ $metadataName }}.standards' />
    </x-forms.field>
    <x-forms.field label="Practices" name="practices" is-expanded>
      <x-forms.practices multiple wire:model.defer='{{ $metadataName }}.practices' />
    </x-forms.field>
    <x-forms.field label="Programming Languages" name="languages" is-expanded>
      <x-forms.languages multiple wire:model.defer='{{ $metadataName }}.languages' />
    </x-forms.field>
    <x-forms.field label="Category" name="category" is-expanded>
      <x-forms.categories wire:model.defer='{{ $metadataName }}.category' />
    </x-forms.field>
    <x-forms.field label="Audience" name="audience" is-expanded>
      <x-forms.audiences wire:model.defer='{{ $metadataName }}.audience' />
    </x-forms.field>
  </x-dynamic-component>
@endunless
