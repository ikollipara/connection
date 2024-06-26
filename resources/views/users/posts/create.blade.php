{{--
file: resources/views/users/posts/create.blade.php
author: Ian Kollipara
date: 2024-06-17
description: The HTML for the create post page
 --}}

@php
  $title = 'conneCTION - Create Post';
  $body = old('body') ?? '{"blocks": []}';
@endphp

<x-layout :title="$title" no-livewire>
  <x-hero x-data="{}" class="is-primary" hero-body-class="level">
    <x-help title="Post Editor">
      <p class="content has-text-black">
        This is the post editor! Here you can write your post and publish it to the world.
        The metadata accessed via the 'publish' or 'update metadata' button let's you set
        certain attributes about the post that make it easier for people to find. Lastly,
        there is no autosave, so consider saving frequently.
      </p>
    </x-help>
    <x-unsaved-indicator />
    <input type="hidden" name="_token" value="{{ csrf_token() }}" form="create-post-form" />
    <x-forms.input has-addons without-label form="create-post-form" name="title" placeholder="Post Title..."
      x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor:unsaved')"
      field-classes="is-flex-grow-1">
      <div class="control">
        <button type="submit" form="create-post-form" class="button is-dark">Save</button>
      </div>
      <div class="control">
        <x-modal title="Set Metadata" btn="Metadata">
          <x-metadata.form id="create-post-form" method="POST" action="{{ route('users.posts.store', 'me') }}" />
          <x-slot name="footer">
            <button x-on:click="show = false" form="create-post-form" type="submit"
              class="button is-primary preserve-rounding">
              Update
            </button>
          </x-slot>
        </x-modal>
      </div>
      <div class="control">
        <input id="post-publish" type="hidden" name="published" form="create-post-form" value="0">
        <button type="submit" form="create-post-form" x-on:click="document.getElementById('post-publish').value = '1'"
          class="button is-link">Publish</button>
      </div>
    </x-forms.input>
  </x-hero>
  <x-container is-fluid class="mt-5">
    <x-editor form="create-post-form" name="body" value="{!! $body !!}" />
  </x-container>
</x-layout>
