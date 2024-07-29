{{--
file: resources/views/dashboard.blade.php
author: Ian Kollipara
date: 2024-06-17
description: The HTML for the dashboard page
 --}}

@php
  $title = 'conneCTION - ' . auth()->user()->full_name . '\'s Dashboard';
@endphp

<x-layout :title="$title"
          no-livewire>
  <x-hero class="is-primary">
    <h1 class="title">conneCTION Dashboard</h1>
  </x-hero>
  <x-container class="mt-5"
               is-fluid>
    <x-tabs tab-titles="Top Content Last Month, Your Follower Feed">
      <x-tabs.tab title="Top Content Last Month">
        <x-table :items="$top_content"
                 row-component="dashboard.row" />
      </x-tabs.tab>
      <x-tabs.tab title="Your Follower Feed">
        <x-table :items="$new_follower_content"
                 row-component="dashboard.row">
          <x-slot name="empty">
            <tr>
              <td colspan="5">
                <p class="content is-medium has-text-centered">
                  @if (auth()->user()->following()->count() > 0)
                    No posts or collections from your followers yet.
                  @else
                    You are not following anyone yet.
                  @endif
                </p>
              </td>
            </tr>
          </x-slot>
        </x-table>
      </x-tabs.tab>
    </x-tabs>
  </x-container>
</x-layout>
