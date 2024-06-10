{{--
file: resources/views/users/show.blade.php
author: Ian Kollipara
date: 2024-06-06
description: This file contains the HTML for displaying a user's profile.
 --}}

@php
  $title = 'conneCTION - ' . $user->full_name;
@endphp

<x-layout :title="$title">
  <x-hero class="is-primary">
    <x-users.profile :user="$user" />
  </x-hero>
  <x-container is-fluid class="mt-5">
    <x-tabs tab-titles="Biography, Top Posts, Top Collections">
      <x-tabs.tab title="Biography">
        <x-editor read-only name="bio" value="{!! json_encode($user->profile->bio) !!}" />
      </x-tabs.tab>
      <x-tabs.tab title="Top Posts">
        <table class="table is-fullwidth">
          <tbody>
            @foreach ($posts as $post)
              <x-search.row :item="$post" :show-user="false" />
            @endforeach
          </tbody>
        </table>
      </x-tabs.tab>
      <x-tabs.tab title="Top Collections">
        <table class="table is-fullwidth">
          <tbody>
            @foreach ($collections as $collection)
              <x-search.row :item="$collection" :show-user="false" />
            @endforeach
          </tbody>
        </table>
      </x-tabs.tab>
    </x-tabs>
  </x-container>
</x-layout>
