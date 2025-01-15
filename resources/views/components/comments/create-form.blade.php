{{--
file: resources/views/components/comments/create-form.blade.php
author: Ian Kollipara
date: 2024-06-24
description: Comment create form component
 --}}

@props(['action'])

@php
  $title = 'Create Comment';
@endphp

<x-modal :title="$title"
         btn="Create Comment">
  <form id="create-comment-form"
        action="{{ $action }}"
        method="post">
    @csrf
    {{ $slot }}
    <x-forms.textarea name="body"
                      label="Comment"
                      required />
  </form>
  <x-slot name="footer">
    <button class="button is-primary"
            form="create-comment-form"
            type="submit">
      Create Comment
    </button>
  </x-slot>
</x-modal>
