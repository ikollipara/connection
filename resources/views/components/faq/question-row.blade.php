{{--
file: resources/views/components/faq/question-row.blade.php
author: Ian Kollipara
date: 2024-06-03
description: Frequently Asked Questions (FAQ) question row
--}}

@props(['question'])

@dd($question)

@php
  use Illuminate\Support\Str;
  $title = __(Str::limit($question->title, 20));
  $excerpt = __(Str::limtit($question->answer, 20));
  $rating_percent = ($question->rating / $question->rating->length) * 100 . '%';
@endphp

<tr>
  <td>{{ $title }}</td>
  <td>{{ $excerpt }}</td>
  <td>{{ $rating_percent }}</td>
  <td>
    <a class="link" href="{{ route('faq.show', compact('question')) }}">Visit</a>
  </td>
</tr>
