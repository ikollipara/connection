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
  <form {{ $attributes }}
        method="POST">
    @csrf
    @if ($method !== 'POST')
      @method($method)
    @endif
    <x-forms.select name="metadata[grades]"
                    :selected="$metadata['grades']"
                    label="Grade"
                    :enum="Grade::class"
                    multiple />
    <x-forms.select name="metadata[standards]"
                    :selected="$metadata['standards']"
                    label="Standard"
                    :enum="Standard::class"
                    multiple />
    <x-forms.select name="metadata[practices]"
                    :selected="$metadata['practices']"
                    label="Practice"
                    :enum="Practice::class"
                    multiple />
    <x-forms.select name="metadata[languages]"
                    :selected="$metadata['languages']"
                    label="Programming Language"
                    :enum="Language::class"
                    multiple />
    <x-forms.select name="metadata[category]"
                    :selected="$metadata['category']"
                    label="Category"
                    :enum="Category::class" />
    <x-forms.select name="metadata[audience]"
                    :selected="$metadata['audience']"
                    label="Audience"
                    :enum="Audience::class" />
  </form>
@else
  <x-dynamic-component :component="$component"
                       {{ $attributes }}>
    <x-forms.select name="grade"
                    label="Grade"
                    :enum="Grade::class"
                    multiple />
    <x-forms.select name="standard"
                    label="Standard"
                    :enum="Standard::class"
                    multiple />
    <x-forms.select name="practice"
                    label="Practice"
                    :enum="Practice::class"
                    multiple />
    <x-forms.select name="language"
                    label="Programming Language"
                    :enum="Language::class"
                    multiple />
    <x-forms.select name="category"
                    label="Category"
                    :enum="Category::class" />
    <x-forms.select name="audience"
                    label="Audience"
                    :enum="Audience::class" />
  </x-dynamic-component>
@endunless
