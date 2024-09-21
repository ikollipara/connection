{{--
file: resources/views/frequently-asked-questions/create.blade.php
author: Ian Kollipara
date: 2024-06-03
description: Frequently Asked Questions (FAQ) create page
--}}

<x-layout :title="'conneCTION' . __('Create Question')">
  <x-hero class="is-primary">
    <h1 class="title">Create Question</h1>
  </x-hero>
  <x-container class="mt-5"
               is-fluid>
    <form action="{{ route('faq.store') }}"
          method="POST">
      @csrf
      <x-forms.input name="title"
                     label="Title" />
      <x-forms.textarea name="content"
                        label="Extra Context" />
      <button class="button is-primary"
              type="submit">Submit</button>
    </form>
  </x-container>
</x-layout>
