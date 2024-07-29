{{--
file: resources/views/form/open.blade.php
author: Ian Kollipara
date: 2024-07-26
description: The HTML for the open form component
 --}}

<form id="{{ $id }}"
      action="{{ $action }}"
      method="{{ $isGet ? 'get' : 'post' }}"
      {!! $attributesString !!}>
  @csrf
  @method($method)
