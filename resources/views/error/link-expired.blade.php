<x-layout title="conneCTION - Link Expired">
  <x-hero class="is-danger">
    <h1 class="title">Link Expired</h1>
    <p class="subtitle">
      The link you clicked has expired. Please request a new one.
      <br>
      {{ $message ?? '' }}
    </p>
  </x-hero>
</x-layout>
