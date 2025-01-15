{{--
file: resources/views/search/partials/filters.blade.php
author: Ian Kollipara
date: 2024-09-23
description: The filters for the search form
 --}}

@php
  use Illuminate\Support\Arr;
  use App\Enums\Category;
  use App\Enums\Standard;
  use App\Enums\Practice;
  use App\Enums\Grade;
  use App\Enums\Language;
  use App\Enums\Audience;

  $types = [
      literal(value: 'post', label: 'Posts'),
      literal(value: 'collection', label: 'Collections'),
      literal(value: 'event', label: 'Events'),
  ];
@endphp

<aside class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
       id="logo-sidebar"
       aria-label="Sidebar">
  <h2 class="text-3xl font-bold dark:text-white text-center pb-3">Filters</h2>
  <div class="h-full px-3 pb-16 overflow-y-auto bg-white dark:bg-gray-800">
    <ul class="space-y-2 font-medium">
      <li>
        <label class="block mb-3"
               for="">
          <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">Types</span>
          <x-form-help-text message="Select the type of content you want to search for." />
          <x-form-select name="type"
                         form-name="{{ $formName }}"
                         :options="$types"
                         :selected="request('type')"
                         placeholder="Type" />
        </label>
      </li>
      <li>
        <label class="block mb-3"
               for="">
          <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">Category</span>
          <x-form-help-text message="Filter the results by the category." />
          <x-form-select name="category"
                         form-name="{{ $formName }}"
                         :options="Category::cases()"
                         :selected="request('category')"
                         placeholder="Category" />
        </label>
      </li>
      <li>
        <label class="block mb-3"
               for="">
          <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">Practices</span>
          <x-form-help-text
                            message="Filter the results by the practice. Each selected practice requires that the result has both." />
          <x-form-select name="practices"
                         form-name="{{ $formName }}"
                         :options="Practice::cases()"
                         :selected="request('practices')"
                         placeholder="Practices"
                         multiple />
        </label>
      </li>
      <li>
        <label class="block mb-3"
               for="">
          <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">Standards</span>
          <x-form-help-text
                            message="Filter the results by the standard. Each selected standard requires that the result has both." />
          <x-form-select name="standards"
                         form-name="{{ $formName }}"
                         :options="Standard::cases()"
                         :selected="request('standards')"
                         placeholder="Standards"
                         multiple />
        </label>
      </li>
      <li>
        <label class="block mb-3"
               for="">
          <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">Grades</span>
          <x-form-help-text
                            message="Filter the results by the grade. Each selected grade requires that the result has both." />
          <x-form-select name="grades"
                         form-name="{{ $formName }}"
                         :options="Grade::cases()"
                         :selected="request('grades')"
                         placeholder="Grades"
                         multiple />
        </label>
      </li>
      <li>
        <label class="block mb-3"
               for="">
          <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">Languages</span>
          <x-form-help-text
                            message="Filter the results by the programming language. Each selected language requires that the result has both." />
          <x-form-select name="languages"
                         form-name="{{ $formName }}"
                         :options="Language::cases()"
                         :selected="request('languages')"
                         placeholder="Languages"
                         multiple />
        </label>
      </li>
      <li>
        <label class="block mb-3"
               for="">
          <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">Audience</span>
          <x-form-help-text message="Filter the results by the audience." />
          <x-form-select name="audience"
                         form-name="{{ $formName }}"
                         :selected="request('audience')"
                         :options="Audience::cases()"
                         placeholder="Audience" />
        </label>
      </li>
      <li>
        <label class="block mb-3"
               for="">
          <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block"># of Likes</span>
          <x-form-help-text message="Limit the results to have at least or more number of likes." />
          <x-form-input name="likes"
                        form-name="{{ $formName }}"
                        type="number"
                        value="{{ request('likes', 0) }}"
                        min="0"
                        placeholder="Likes" />
        </label>
      </li>
      <li>
        <label class="block mb-3"
               for="">
          <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block"># of Views</span>
          <x-form-help-text message="Limit the results to have at least or more number of views." />
          <x-form-input name="views"
                        form-name="{{ $formName }}"
                        type="number"
                        value="{{ request('views', 0) }}"
                        min="0"
                        placeholder="Views" />
        </label>
      </li>
    </ul>
  </div>
</aside>
