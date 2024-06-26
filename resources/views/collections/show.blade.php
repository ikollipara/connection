{{--
file: resources/views/collections/show.blade.php
author: Ian Kollipara
date: 2024-06-24
description: The view for showing a collection
 --}}

@php
  $title = 'conneCTION - ' . $collection->title;
  $avatar = $collection->user ? $collection->user->avatar : 'https://ui-avatars.com/api/?name=Deleted&color=7F9CF5&background=EBF4FF';
  $full_name = $collection->user ? $collection->user->full_name : 'Deleted';
  $short_title = $collection->user ? $collection->user->profile->short_title : '';
  $route = $liked_by_user ? route('content.likes.destroy', [$collection, $liked_by_user->id]) : route('content.likes.store', $collection);
@endphp

<x-layout :title="$title" no-livewire>
  <x-hero class="is-primary" hero-body-class="has-text-centered">
    <h1 class="title is-1">{{ $collection->title }}</h1>
    <div class="column is-align-items-center is-justify-content-center">
      <figure class="image is-64x64"><img src="{{ $avatar }}" alt=""></figure>
      <a @if ($collection->user) href="{{ route('users.show', $collection->user) }}" @endif
        class="link is-italic">
        {{ $full_name }} - {{ $short_title }}
      </a>
    </div>
    <div class="level bordered">
      <div class="level-left">
        <x-bulma-icon icon="lucide-eye">{{ $collection->views_count }}</x-bulma-icon>
        <form action="{{ $route }}" method="post">
          @csrf
          @method($liked_by_user ? 'DELETE' : 'POST')
          <input type="hidden" name="user_id" value="{{ auth()->id() }}">
          <button type="submit" class="button is-primary">
            <x-bulma-icon fill="{{ $liked_by_user ? 'white' : 'none' }}"
              icon="lucide-heart">{{ $collection->likes_count }}</x-bulma-icon>
          </button>
        </form>
      </div>
      <div class="level-right">
        <x-add-to-collection :content="$collection" :collections="auth()->user()->collections" />
        <a href="{{ route('collections.comments.index', $collection) }}" class="button is-primary">See Comments</a>
      </div>
    </div>
  </x-hero>
  <x-container is-fluid class="mt-5">
    <x-tabs tab-titles="Description, Entries">
      <x-tabs.tab title="Description">
        <details class="is-clickable">
          <summary>Metadata</summary>
          <x-metadata.table :metadata="$collection->metadata" />
        </details>
        <section>
          <x-editor value="{{ Js::from($collection->body) }}" name="editor" read-only />
        </section>
      </x-tabs.tab>
      <x-tabs.tab title="Entries">
        <x-table>
          @forelse ($collection->entries as $entry)
            <tr>
              <td>{{ $entry->title }}</td>
              <td>
                @if ($entry->user)
                  {{ $entry->user->full_name }}
                @else
                  [Deleted]
                @endif
              </td>
              <td><a href="{{ URL::route("{$entry->type}s.show", [$entry]) }}">Visit</a></td>
            </tr>
          @empty
            <tr>
              <td colspan="3">No entries yet.</td>
            </tr>
          @endforelse
        </x-table>
      </x-tabs.tab>
    </x-tabs>
  </x-container>
</x-layout>
