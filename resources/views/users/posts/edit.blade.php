{{--
file: resources/views/users/posts/edit.blade.php
author: Ian Kollipara
date: 2024-09-11
description: The HTML for the edit post page
 --}}

<x-writing-layout title="New Post"
                  drawer-name="edit-post-drawer"
                  show-save>
  @include('users.posts.partials.auto-save-warning')
  @include('users.posts.partials.form', [
      'action' => route('users.posts.update', ['me', $post]),
      'formName' => 'edit-post',
      'post' => $post,
      'method' => 'put',
      'drawerName' => 'edit-post-drawer',
      'drawerAction' => route('users.posts.publish', ['me', $post]),
  ])
</x-writing-layout>
