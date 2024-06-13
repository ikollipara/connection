{{--
file: resources/views/search.blade.php
author: Ian Kollipara
date: 2024-06-13
description: This file contains the HTML for the search page.
 --}}

@php
  $title = 'conneCTION - Search';
  use App\Enums\StandardGroup;
  use App\Enums\Standard;
  use App\Enums\Practice;
  use App\Enums\Grade;
  use App\Enums\Category;
  use App\Enums\Audience;
  use App\Enums\Language;
@endphp

<x-layout :title="$title" no-livewire>
  <x-container is-fluid class="mt-5 columns is-multiline">
    <section class="column is-full is-flex">
      <x-forms.input field-classes="is-flex-grow-1" tabindex="0" form="search" name="q" placeholder="Search..."
        without-label />
      <div class="control"><button form="search" class="button is-primary" type="submit">Search</button></div>
    </section>
    <form id="search" method="get" action="{{ url()->current() }}" class="column is-one-quarter">
      <h2 class="subtitle is-4">Advanced Search</h2>
      <x-forms.field>
        <select class="select" name="type">
          <option @if (old('type')) selected @endif value="">Both</option>
          <option @if (old('type')) selected @endif value="post">Post</option>
          <option @if (old('type')) selected @endif value="collection">Collection</option>
        </select>
      </x-forms.field>
      <x-forms.input type="number" name="likes_count" min="0" label="Minimum Likes" value="0" />
      <x-forms.input type="number" name="views_count" min="0" label="Minimum Views" value="0" />
      <x-forms.select name="standard_groups" label="Standard Groups" :enum="StandardGroup::class" multiple />
      <x-forms.select name="standards" label="Standards" :enum="Standard::class" multiple />
      <x-forms.select name="practices" label="Practices" :enum="Practice::class" multiple />
      <x-forms.select name="grades" label="Grades" :enum="Grade::class" multiple />
      <x-forms.select name="categories" label="Categories" :enum="Category::class" multiple />
      <x-forms.select name="audiences" label="Audiences" :enum="Audience::class" multiple />
      <x-forms.select name="languages" label="Languages" :enum="Language::class" multiple />
    </form>
    <main class="column is-three-quarters">
      <table class="table is-fullwidth">
        <tbody>
          @forelse ($results as $result)
            <x-search.row :item="$result" />
          @empty
            <tr>
              <td colspan="6" class="content is-medium">No Results</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </main>
  </x-container>
</x-layout>
