{{--
file: resources/views/users/posts/create.blade.php
author: Ian Kollipara
date: 2024-09-09
description: The HTML for the create post page
 --}}

<x-writing-layout title="New Post"
                  drawer-name="create-post-drawer">
  @include('users.posts.partials.form', [
      'action' => route('api.users.posts.store', $user),
      'formName' => 'create-post',
      'post' => $post,
      'method' => 'post',
      'drawerName' => 'create-post-drawer',
      'drawerAction' => route('users.posts.publish', 'me'),
  ])
</x-writing-layout>
