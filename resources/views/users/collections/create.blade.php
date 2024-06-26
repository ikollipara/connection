{{--
file: resources/views/users/collections/create.blade.php
author: Ian Kollipara
date: 2024-06-24
description: The HTML for the create collection form
 --}}

@php
  $title = 'conneCTION - Create Collection';
  $body = old('body') ?? '{"blocks": []}';
@endphp

<x-layout :title="$title" no-livewire>
  <x-hero x-data="{}" class="is-primary" hero-body-class="level">
    <x-help title="Collection Editor">
      <p class="content has-text-black">
        This is the collection editor! Here you can write your collection and publish it to the world.
        The metadata accessed via the 'publish' or 'update metadata' button let's you set certain attributes
        about the collection that make it easier for people to find. Upon saving, you are able to add a post
        to the collection using the bookmark icon found on posts. Lastly, there is no autosave, so consider saving
        frequently.
      </p>
    </x-help>
    <x-unsaved-indicator />
    <input type="hidden" name="_token" value="{{ csrf_token() }}" form="create-collection-form">
    <x-forms.input has-addons without-label form="create-collection-form" name="title"
      placeholder="Collection Title..."
      x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor:unsaved')"
      field-classes="is-flex-grow-1">
      <div class="control">
        <button type="submit" form="create-collection-form" class="button is-dark">Save</button>
      </div>
      <div class="control">
        <x-modal title="Set Metadata" btn="Metadata">
          <x-metadata.form id="create-collection-form" method="POST"
            action="{{ route('users.collections.store', 'me') }}" />
          <x-slot name="footer">
            <button x-on:click="show = false" form="create-collection-form" type="submit"
              class="button is-primary preserve-rounding">
              Update
            </button>
          </x-slot>
        </x-modal>
      </div>
      <div class="control">
        <input id="collection-publish" type="hidden" name="published" form="create-collection-form" value="0">
        <button type="submit" form="create-collection-form"
          x-on:click="document.getElementById('collection-publish').value = '1';"
          class="button is-link">Publish</button>
      </div>
    </x-forms.input>
  </x-hero>
  <x-container is-fluid class="mt-5">
    <x-editor form="create-collection-form" name="body" value="{!! $body !!}" />
  </x-container>
</x-layout>
