{{--
file: resources/views/users/collections/edit.blade.php
author: Ian Kollipara
date: 2024-06-24
description: Edit view for a collection
 --}}

<x-writing-layout title="New Collection"
                  drawer-name="edit-collection-drawer"
                  show-save>
  @include('users.posts.partials.auto-save-warning')
  @include('users.collections.partials.form', [
      'action' => route('users.collections.update', ['me', $collection]),
      'formName' => 'edit-collection',
      'collection' => $collection,
      'method' => 'put',
      'drawerName' => 'edit-collection-drawer',
      'drawerAction' => route('users.collections.publish', ['me', $collection]),
  ])
  @includeWhen($collection->exists(), 'users.collections.partials.entries', ['collection' => $collection])
</x-writing-layout>
