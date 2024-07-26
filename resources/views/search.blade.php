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

<x-layout :title="$title"
          no-livewire>
  <x-container class="mt-5 columns is-multiline"
               is-fluid>
    <section class="column is-full is-flex">
      <x-forms.input name="q"
                     form="search"
                     tabindex="0"
                     field-classes="is-flex-grow-1"
                     placeholder="Search..."
                     without-label />
      <div class="control">
        <button class="button is-primary"
                form="search"
                type="submit">
          Search
        </button>
      </div>
    </section>
    <form class="column is-one-quarter"
          id="search"
          method="get"
          action="{{ url()->current() }}">
      <h2 class="subtitle is-4">Advanced Search</h2>
      <x-forms.field>
        <select class="select"
                name="type">
          <option value=""
                  @if (old('type') === '') selected @endif>Both</option>
          <option value="post"
                  @if (old('type') === 'post') selected @endif>Post</option>
          <option value="collection"
                  @if (old('type') === 'collection') selected @endif>Collection</option>
        </select>
      </x-forms.field>
      <x-forms.input name="likes_count"
                     type="number"
                     value="0"
                     min="0"
                     label="Minimum Likes" />
      <x-forms.input name="views_count"
                     type="number"
                     value="0"
                     min="0"
                     label="Minimum Views" />
      <x-forms.select name="standard_groups"
                      label="Standard Groups"
                      :enum="StandardGroup::class"
                      multiple />
      <x-forms.select name="standards"
                      label="Standards"
                      :enum="Standard::class"
                      multiple />
      <x-forms.select name="practices"
                      label="Practices"
                      :enum="Practice::class"
                      multiple />
      <x-forms.select name="grades"
                      label="Grades"
                      :enum="Grade::class"
                      multiple />
      <x-forms.select name="categories"
                      label="Categories"
                      :enum="Category::class"
                      multiple />
      <x-forms.select name="audiences"
                      label="Audiences"
                      :enum="Audience::class"
                      multiple />
      <x-forms.select name="languages"
                      label="Languages"
                      :enum="Language::class"
                      multiple />
    </form>
    <main class="column is-three-quarters">
      <table class="table is-fullwidth">
        <tbody>
          @forelse ($results as $result)
            <x-search.row :item="$result" />
          @empty
            <tr>
              <td class="content is-medium"
                  colspan="6">No Results</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </main>
  </x-container>
</x-layout>
