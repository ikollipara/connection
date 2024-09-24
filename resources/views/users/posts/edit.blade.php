{{--
file: resources/views/users/posts/edit.blade.php
author: Ian Kollipara
date: 2024-09-11
description: The HTML for the edit post page
 --}}

<x-writing-layout title="New Post"
                  drawer-name="edit-post-drawer">
  @include('users.posts.partials.form', [
      'action' => route('api.users.posts.update', [$user, $post]),
      'formName' => 'edit-post',
      'post' => $post,
      'method' => 'put',
      'drawerName' => 'edit-post-drawer',
      'drawerAction' => route('users.posts.publish', ['me', $post]),
  ])
</x-writing-layout>

{{--
file: resources/views/users/posts/edit.blade.php
author: Ian Kollipara
date: 2024-06-19
description: The HTML for the edit post page
 --}}

{{-- @php
  $title = "conneCTION - Edit {$post->title}";
  $body = old('body', $post->body->toArray());
  $body = is_string($body) ? $body : json_encode($body);
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
    <x-add-to-collection :content="$post"
                         :collections="$user->collections" />
    <x-unsaved-indicator />
    <input name="_token"
           form="edit-post-form"
           type="hidden"
           value="{{ csrf_token() }}" />
    <x-forms.input name="title"
                   form="edit-post-form"
                   value="{{ $post->title }}"
                   has-addons
                   without-label
                   placeholder="Post Title..."
                   x-on:change="document.title = `conneCTION - ${$el.value}`; $dispatch('editor:unsaved')"
                   field-classes="is-flex-grow-1">
      <div class="control">
        <button class="button is-dark"
                form="edit-post-form"
                type="submit">Save</button>
      </div>
      <div class="control">
        <x-modal title="Set Metadata"
                 btn="Metadata">
          <x-metadata.form id="edit-post-form"
                           method="PATCH"
                           action="{{ route('users.posts.update', ['me', $post]) }}"
                           :metadata="$post->metadata->toArray()" />
          <x-slot name="footer">
            <button class="button is-primary preserve-rounding"
                    form="edit-post-form"
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
               form="edit-post-form"
               type="hidden"
               value="{{ $post->published ? '1' : '0' }}">
        @unless ($post->published)
          <button class="button is-link"
                  form="edit-post-form"
                  type="submit"
                  x-on:click="document.getElementById('post-publish').value = '1'">Publish</button>
        @endunless
      </div>
      <div class="control">
        <form id="archive-post-form"
              action="{{ route('users.posts.update', ['me', $post]) }}"
              method="post">
          @csrf
          @method('PATCH')
          <input name="archive"
                 type="hidden"
                 value="{{ $post->trashed() ? '0' : '1' }}">
          <button class="button is-danger has-text-white"
                  form="archive-post-form"
                  type="submit">
            {{ $post->trashed() ? 'Restore' : 'Archive' }}
          </button>
        </form>
      </div>
    </x-forms.input>
  </x-hero>
  <x-container class="mt-5"
               is-fluid>
    <x-editor name="body"
              form="edit-post-form"
              value="{!! $body !!}" />
  </x-container>
</x-layout> --}}
