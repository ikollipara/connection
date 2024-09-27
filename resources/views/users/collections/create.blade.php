{{--
file: resources/views/users/collections/create.blade.php
author: Ian Kollipara
date: 2024-06-24
description: The HTML for the create collection form
 --}}

<x-writing-layout title="New Collection"
                  drawer-name="create-collection-drawer"
                  show-save>
  @include('users.posts.partials.auto-save-warning')
  @include('users.collections.partials.form', [
      'action' => route('users.collections.store', 'me'),
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
