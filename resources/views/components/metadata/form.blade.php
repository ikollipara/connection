{{--
file: resources/views/components/metadata/form.blade.php
author: Ian Kollipara
date: 2024-05-30
description: The form for setting metadata
 --}}

@props(['metadata' => null, 'component' => null, 'method' => 'POST'])

@php
  use App\Enums\Grade;
  use App\Enums\Language;
  use App\Enums\Practice;
  use App\Enums\Standard;
  use App\Enums\Category;
  use App\Enums\Audience;
  $metadata = $metadata ?? [
      'grades' => [],
      'standards' => [],
      'practices' => [],
      'languages' => [],
      'category' => Category::material(),
      'audience' => Audience::teachers(),
  ];
@endphp

@unless ($component)
  <form {{ $attributes }} method="POST">
    @csrf
    @if ($method !== 'POST')
      @method($method)
    @endif
    <x-forms.select :selected="$metadata['grades']" label="Grade" name="metadata[grades]" :enum="Grade::class" multiple />
    <x-forms.select :selected="$metadata['standards']" label="Standard" name="metadata[standards]" :enum="Standard::class" multiple />
    <x-forms.select :selected="$metadata['practices']" label="Practice" name="metadata[practices]" :enum="Practice::class" multiple />
    <x-forms.select :selected="$metadata['languages']" label="Programming Language" name="metadata[languages]" :enum="Language::class" multiple />
    <x-forms.select :selected="$metadata['category']" label="Category" name="metadata[category]" :enum="Category::class" />
    <x-forms.select :selected="$metadata['audience']" label="Audience" name="metadata[audience]" :enum="Audience::class" />
  </form>
@else
  <x-dynamic-component :component="$component" {{ $attributes }}>
    <x-forms.select label="Grade" name="grade" :enum="Grade::class" multiple />
    <x-forms.select label="Standard" name="standard" :enum="Standard::class" multiple />
    <x-forms.select label="Practice" name="practice" :enum="Practice::class" multiple />
    <x-forms.select label="Programming Language" name="language" :enum="Language::class" multiple />
    <x-forms.select label="Category" name="category" :enum="Category::class" />
    <x-forms.select label="Audience" name="audience" :enum="Audience::class" />
  </x-dynamic-component>
@endunless
