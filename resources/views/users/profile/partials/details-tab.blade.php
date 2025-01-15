{{--
file: resources/views/users/profile/partials/details-tab.blade.php
author: Ian Kollipara
date: 2024-09-21
description: The details tab for the user profile
 --}}

@use('App\Enums\Grade')

<div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
     id="details"
     role="tabpanel"
     aria-labelledby="details-tab"
     x-data="{ isPreservice: {{ Js::from($profile->is_preservice) }} }">
  <label class="block mb-3">
    <span class="mb-2 text-sm font-medium text-gray-900 dark:text-white block">School</span>
    <x-form-input name="school" />
    <x-form-help-text
                      message="The school you are currently teaching at. If you are a pre-service teacher, please input your university." />
    <x-form-input-error name="school" />
  </label>
  <label class="block mb-3">
    <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
      Subject
    </span>
    <x-form-input name="subject" />
    <x-form-help-text message="The subject that you teach. If you are teaching multiple subjects, list them all." />
    <x-form-input-error name="subject" />
  </label>
  <div class="flex items-center mb-4">
    <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
           id="is_preservice"
           name="is_preservice"
           type="checkbox"
           x-model="isPreservice"
           @checked($profile->is_preservice) />
    <label class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
           for="is_preservice">I am a pre-service teacher</label>
  </div>
  <template x-if="!isPreservice">
    <label class="block mb-3">
      <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Years of Experience
      </span>
      <x-form-input name="years_of_experience"
                    type="number"
                    value="{{ $profile->years_of_experience }}"
                    min="0" />
      <x-form-help-text message="How many years you have taught. If you are in your first year, please put 0." />
      <x-form-input-error name="years_of_experience" />
    </label>
  </template>
  <label class="block mb-3">
    <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
      Grades
    </span>
    <x-form-select name="grades"
                   :options="Grade::cases()"
                   multiple
                   :selected="$profile->grades" />
    <x-form-help-text message="The grades that you teach. Please list them all." />
    <x-form-input-error name="grades" />
  </label>
</div>
