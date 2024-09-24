{{--
file: resources/views/users/collections/edit.blade.php
author: Ian Kollipara
date: 2024-06-24
description: Edit view for a collection
 --}}

<x-writing-layout title="New Collection"
                  drawer-name="edit-collection-drawer">
  @include('users.collections.partials.form', [
      'action' => route('api.users.collections.update', [$user, $collection]),
      'formName' => 'edit-collection',
      'collection' => $collection,
      'method' => 'put',
      'drawerName' => 'edit-collection-drawer',
      'drawerAction' => route('users.collections.publish', ['me', $collection]),
  ])
  @includeWhen($collection->exists(), 'users.collections.partials.entries', ['collection' => $collection])
</x-writing-layout>

{{-- @php
  $title = 'conneCTION - Edit ' . ($collection->title ? $collection->title : 'Unnamed Collection');
  $body = old('body', $collection->body->toArray());
  $body = is_string($body) ? $body : json_encode($body);
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
    <x-add-to-collection :content="$collection"
                         :collections="$user->collections" />
    <x-unsaved-indicator />
    <input name="_token"
           form="edit-collection-form"
           type="hidden"
           value="{{ csrf_token() }}">
    <x-forms.input name="title"
                   form="edit-collection-form"
                   value="{{ $collection->title }}"
                   has-addons
                   without-label
                   placeholder="Collection Title..."
                   x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor:unsaved')"
                   field-classes="is-flex-grow-1">
      <div class="control">
        <button class="button is-dark"
                form="edit-collection-form"
                type="submit">Save</button>
      </div>
      <div class="control">
        <x-modal title="Set Metadata"
                 btn="Metadata">
          <x-metadata.form id="edit-collection-form"
                           method="PATCH"
                           action="{{ route('users.collections.update', ['me', $collection]) }}"
                           :metadata="$collection->metadata->toArray()" />
          <x-slot name="footer">
            <button class="button is-primary preserve-rounding"
                    form="edit-collection-form"
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
               form="edit-collection-form"
               type="hidden"
               value="{{ $collection->published ? '1' : '0' }}">
        @unless ($collection->published)
          <button class="button is-link"
                  form="edit-collection-form"
                  type="submit"
                  x-on:click="document.getElementById('collection-publish').value = '1'">Publish</button>
        @endunless
      </div>
      <div class="control">
        <form id="archive-collection-form"
              action="{{ route('users.collections.update', ['me', $collection]) }}"
              method="post">
          @csrf
          @method('PATCH')
          <input name="archive"
                 type="hidden"
                 value="{{ $collection->trashed() ? '0' : '1' }}">
          <button class="button is-danger has-text-white"
                  form="archive-collection-form"
                  type="submit">
            {{ $collection->trashed() ? 'Restore' : 'Archive' }}
          </button>
        </form>
      </div>
    </x-forms.input>
  </x-hero>
  <x-container class="mt-5"
               is-fluid>
    <x-tabs tab-titles="Editor, Entries">
      <x-tabs.tab title="Editor">
        <x-editor name="body"
                  form="edit-collection-form"
                  value="{!! $body !!}" />
      </x-tabs.tab>
      <x-tabs.tab title="Entries">
        <x-table row-component="users.collections.entry-row"
                 :items="$collection->entries">
          <x-slot name="empty">
            <tr>
              <td class="subtitle is-3 has-text-centered"
                  colspan="4">No Items in this Collection. You should add
                some!</td>
            </tr>
          </x-slot>
        </x-table>
      </x-tabs.tab>
    </x-tabs>
  </x-container>
</x-layout> --}}
