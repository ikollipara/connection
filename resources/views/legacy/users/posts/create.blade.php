{{--
file: resources/views/users/posts/create.blade.php
author: Ian Kollipara
date: 2024-09-09
description: The HTML for the create post page
 --}}

<x-writing-layout title="New Post"
                  drawer-name="create-post-drawer"
                  show-save>
  @include('users.posts.partials.auto-save-warning')
  @include('users.posts.partials.form', [
      'action' => route('users.posts.store', 'me'),
      'formName' => 'create-post',
      'post' => $post,
      'method' => 'post',
      'drawerName' => 'create-post-drawer',
      'drawerAction' => route('users.posts.publish', 'me'),
  ])
</x-writing-layout>
