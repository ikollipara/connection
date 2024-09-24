{{--
file: resources/views/users/collections/create.blade.php
author: Ian Kollipara
date: 2024-06-24
description: The HTML for the create collection form
 --}}

<x-writing-layout title="New Collection"
                  drawer-name="create-collection-drawer">
  @include('users.collections.partials.form', [
      'action' => route('api.users.collections.store', $user),
      'formName' => 'create-collection',
      'collection' => $collection,
      'method' => 'post',
      'drawerName' => 'create-collection-drawer',
      'drawerAction' => route('users.collections.publish', 'me'),
  ])
  @includeIf($collection->exists(), 'users.collections.partials.entries', [
      'collection' => $collection,
  ])
</x-writing-layout>

{{-- @php
  $title = 'conneCTION - Create Collection';
  $body = old('body', '{"blocks": []}');
@endphp

<x-layout :title="$title"
          no-livewire>
  <x-hero class="is-primary"
          x-data="{}"
          hero-body-class="level">
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
    <input name="_token"
           form="create-collection-form"
           type="hidden"
           value="{{ csrf_token() }}">
    <x-forms.input name="title"
                   form="create-collection-form"
                   has-addons
                   without-label
                   placeholder="Collection Title..."
                   x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor:unsaved')"
                   field-classes="is-flex-grow-1">
      <div class="control">
        <button class="button is-dark"
                form="create-collection-form"
                type="submit">Save</button>
      </div>
      <div class="control">
        <x-modal title="Set Metadata"
                 btn="Metadata">
          <x-metadata.form id="create-collection-form"
                           method="POST"
                           action="{{ route('users.collections.store', 'me') }}" />
          <x-slot name="footer">
            <button class="button is-primary preserve-rounding"
                    form="create-collection-form"
                    type="submit"
                    x-on:click="show = false">
              Update
            </button>
          </x-slot>
        </x-modal>
      </div>
      <div class="control">
        <input id="collection-publish"
               name="published"
               form="create-collection-form"
               type="hidden"
               value="0">
        <button class="button is-link"
                form="create-collection-form"
                type="submit"
                x-on:click="document.getElementById('collection-publish').value = '1';">Publish</button>
      </div>
    </x-forms.input>
  </x-hero>
  <x-container class="mt-5"
               is-fluid>
    <x-editor name="body"
              form="create-collection-form"
              value="{!! $body !!}" />
  </x-container>
</x-layout> --}}
