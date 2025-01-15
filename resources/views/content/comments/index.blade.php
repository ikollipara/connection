{{--
file: resources/views/content/comments/index.blade.php
author: Ian Kollipara
date: 2024-09-22
description: The index view for comments
 --}}

<x-reading-layout title="{{ $content->title }} Comments"
                  wrapper-class="xl:!mx-5 xl:!ml-64">
  <x-slot:aside>
    @include('content.comments.partials.details-sidebar', ['content' => $content])
  </x-slot>
  @includeWhen(auth()->check(), 'content.comments.partials.comment-form', [
      'content' => $content,
      'action' => $action,
  ])
  @foreach ($comments as $comment)
    @include('content.comments.partials.comment', [
        'comment' => $comment,
        'content' => $content,
        'action' => $action,
    ])
  @endforeach
</x-reading-layout>
