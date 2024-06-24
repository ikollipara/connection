{{--
file: resources/views/users/collections/edit.blade.php
author: Ian Kollipara
date: 2024-06-24
description: Edit view for a collection
 --}}

@php
  $title = 'conneCTION - Edit ' . ($collection->title ? $collection->title : 'Unnamed Collection');
  $body = old('body') ?? $collection->body;
  $body = is_string($body) ? $body : json_encode($body);
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
    <x-add-to-collection :content="$collection" :collections="$user->collections" />
    <x-unsaved-indicator />
    <input type="hidden" name="_token" value="{{ csrf_token() }}" form="edit-collection-form">
    <x-forms.input has-addons without-label form="edit-collection-form" name="title" placeholder="Collection Title..."
      x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor:unsaved')"
      value="{{ $collection->title }}" field-classes="is-flex-grow-1">
      <div class="control">
        <button type="submit" form="edit-collection-form" class="button is-dark">Save</button>
      </div>
      <div class="control">
        <x-modal title="Set Metadata" btn="Metadata">
          <x-metadata.form id="edit-collection-form" method="PATCH"
            action="{{ route('users.collections.update', ['me', $collection]) }}" :metadata="$collection->metadata->toArray()" />
          <x-slot name="footer">
            <button x-on:click="show = false" form="edit-collection-form" type="submit"
              class="button is-primary preserve-rounding">
              Update
            </button>
          </x-slot>
        </x-modal>
      </div>
      <div class="control">
        <input id="collection-publish" type="hidden" name="published" form="edit-collection-form"
          value="{{ $collection->published ? '1' : '0' }}">
        @unless ($collection->published)
          <button type="submit" form="edit-collection-form"
            x-on:click="document.getElementById('#collection-publish').value = '1'"
            class="button is-link">Publish</button>
        @endunless
      </div>
      <div class="control">
        <form id="archive-collection-form" action="{{ route('users.collections.update', ['me', $collection]) }}"
          method="post">
          @csrf
          @method('PATCH')
          <input type="hidden" name="archive" value="{{ $collection->trashed() ? '0' : '1' }}">
          <button type="submit" form="archive-collection-form" class="button is-danger has-text-white">
            {{ $collection->trashed() ? 'Restore' : 'Archive' }}
          </button>
        </form>
      </div>
    </x-forms.input>
  </x-hero>
  <x-container is-fluid class="mt-5">
    <x-tabs tab-titles="Editor, Entries">
      <x-tabs.tab title="Editor">
        <x-editor form="edit-collection-form" name="body" value="{!! $body !!}" />
      </x-tabs.tab>
      <x-tabs.tab title="Entries">
        <x-table row-component="users.collections.entry-row" :items="$collection->entries">
          <x-slot name="empty">
            <tr>
              <td colspan="4" class="subtitle is-3 has-text-centered">No Items in this Collection. You should add
                some!</td>
            </tr>
          </x-slot>
        </x-table>
      </x-tabs.tab>
    </x-tabs>
  </x-container>
</x-layout>
