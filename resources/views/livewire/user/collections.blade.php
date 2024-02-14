<div>
  <x-hero class="is-primary">
    <div class="is-flex" style="gap: 1rem;">
      <figure class="image is-128x128 mt-auto mb-auto">
        <img src="{{ $this->user->avatar() }}" alt="">
      </figure>
      <div class="is-flex is-flex-direction-column">
        <h1 class="title is-1">{{ $this->user->full_name() }}</h1>
        <p class="is-italic content">
          {{ $this->user->subject }} Teacher at
          {{ $this->user->school }}
        </p>
  </x-hero>
  <main class="container is-fluid mt-3">
    <table class="table is-fullwidth">
      <thead></thead>
      <tbody>
        @foreach ($this->collections as $collection)
          <x-search.row :item="$collection" :show-user="false" />
        @endforeach
      </tbody>
    </table>
    {{ $this->collections->links('pagination') }}
  </main>
</div>