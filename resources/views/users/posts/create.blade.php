{{--
file: resources/views/users/posts/create.blade.php
author: Ian Kollipara
date: 2024-06-17
description: The HTML for the create post page
 --}}

@php
  $title = 'conneCTION - Create Post';
  $body = old('body', '{"blocks": []}') ?? '{"blocks": []}';
@endphp

<x-layout :title="$title"
          no-livewire>
  <x-hero class="is-primary"
          x-data="{}"
          hero-body-class="level">
    <x-help title="Post Editor">
      <p class="content has-text-black">
        This is the post editor! Here you can write your post and publish it to the world.
        The metadata accessed via the 'publish' or 'update metadata' button let's you set
        certain attributes about the post that make it easier for people to find. Lastly,
        there is no autosave, so consider saving frequently.
      </p>
    </x-help>
    <x-unsaved-indicator />
    <input name="_token"
           form="create-post-form"
           type="hidden"
           value="{{ csrf_token() }}" />
    <x-forms.input name="title"
                   form="create-post-form"
                   has-addons
                   without-label
                   placeholder="Post Title..."
                   x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor:unsaved')"
                   field-classes="is-flex-grow-1">
      <div class="control">
        <button class="button is-dark"
                form="create-post-form"
                type="submit">Save</button>
      </div>
      <div class="control">
        <x-modal title="Set Metadata"
                 btn="Metadata">
          <x-metadata.form id="create-post-form"
                           method="POST"
                           action="{{ route('users.posts.store', 'me') }}" />
          <x-slot name="footer">
            <button class="button is-primary preserve-rounding"
                    form="create-post-form"
                    type="submit"
                    x-on:click="show = false">
              Update
            </button>
          </x-slot>
        </x-modal>
      </div>
      <div class="control">
        <input id="post-publish"
               name="published"
               form="create-post-form"
               type="hidden"
               value="0">
        <button class="button is-link"
                form="create-post-form"
                type="submit"
                x-on:click="document.getElementById('post-publish').value = '1'">Publish</button>
      </div>
    </x-forms.input>
  </x-hero>
  <x-container class="mt-5"
               is-fluid>
    <x-editor name="body"
              form="create-post-form"
              value="{!! $body !!}" />
  </x-container>
</x-layout>
