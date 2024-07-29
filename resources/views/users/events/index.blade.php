<x-layout>
  <x-hero class="is-primary">
    <h1 class="title">My Events</h1>
  </x-hero>
  @include('users.events._calendar', ['events' => $events])
</x-layout>
