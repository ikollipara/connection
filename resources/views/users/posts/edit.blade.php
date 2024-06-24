{{--
file: resources/views/users/posts/edit.blade.php
author: Ian Kollipara
date: 2024-06-19
description: The HTML for the edit post page
 --}}

@php
  $title = "conneCTION - Edit {$post->title}";
  $body = old('body') ?? $post->body;
  $body = is_string($body) ? $body : json_encode($body);
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
    <x-add-to-collection :content="$post" :collections="$user->collections" />
    <x-unsaved-indicator />
    <input type="hidden" name="_token" value="{{ csrf_token() }}" form="edit-post-form" />
    <x-forms.input has-addons without-label form="edit-post-form" name="title" placeholder="Post Title..."
      x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor:unsaved')"
      value="{{ $post->title }}" field-classes="is-flex-grow-1">
      <div class="control">
        <button type="submit" form="edit-post-form" class="button is-dark">Save</button>
      </div>
      <div class="control">
        <x-modal title="Set Metadata" btn="Metadata">
          <x-metadata.form id="edit-post-form" method="PATCH" action="{{ route('users.posts.update', ['me', $post]) }}"
            :metadata="$post->metadata->toArray()" />
          <x-slot name="footer">
            <button x-on:click="show = false" form="edit-post-form" type="submit"
              class="button is-primary preserve-rounding">
              Update
            </button>
          </x-slot>
        </x-modal>
      </div>
      <div class="control">
        <input id="post-publish" type="hidden" name="published" form="edit-post-form"
          value="{{ $post->published ? '1' : '0' }}">
        @unless ($post->published)
          <button type="submit" form="edit-post-form" x-on:click="document.getElementById('#post-publish').value = '1'"
            class="button is-link">Publish</button>
        @endunless
      </div>
      <div class="control">
        <form id="archive-post-form" action="{{ route('users.posts.update', ['me', $post]) }}" method="post">
          @csrf
          @method('PATCH')
          <input type="hidden" name="archive" value="{{ $post->trashed() ? '0' : '1' }}">
          <button type="submit" form="archive-post-form" class="button is-danger has-text-white">
            {{ $post->trashed() ? 'Restore' : 'Archive' }}
          </button>
        </form>
      </div>
    </x-forms.input>
  </x-hero>
  <x-container is-fluid class="mt-5">
    <x-editor form="edit-post-form" name="body" value="{!! $body !!}" />
  </x-container>
</x-layout>
