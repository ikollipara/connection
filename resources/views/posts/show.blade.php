<x-layout title="conneCTION - {{ $post->title }}">
  <span x-data="{ showModal: false }">
    <x-hero class="is-primary">
      <h1 class="title is-1 has-text-centered">{{ $post->title }}</h1>
      <div
        class="is-flex is-flex-direction-column mb-2 is-align-items-center is-justify-content-center has-text-centered"
        style="gap: 0.5rem;">
        <figure class="image is-64x64 is-flex is-justify-content-center is-align-items-center">
          <img style="width: 50px; height: 50px; object-fit:cover;" class="is-rounded" src="{{ $post->user->avatar() }}"
            alt="">
        </figure>
        @if ($post->user)
          <a href="{{ route('users.show', ['user' => $post->user]) }}" class="link is-italic">
            {{ $post->user->full_name() }} - {{ $post->user->subject }} Teacher at
            {{ $post->user->school }}
          </a>
        @else
          <p class="is-italic content">[Deleted]</p>
        @endif
      </div>
      <div class="level" style="padding-block: 0.25rem; border-top: white 1px solid; border-bottom: white 1px solid;">
        <div class="level-left">
          <div class="level-item">
            <p class="icon-text">
              <x-lucide-eye class="icon" width="30" height="30" />
              <span>{{ $post->views }}</span>
            </p>
          </div>
          <div class="level-item">
            @livewire('like-button', ['likable' => $post])
          </div>
        </div>
        <div class="level-right">
          <div class="level-item">
            <button @@click='showModal = true' type="button" class="button is-primary mx-3"
              title="Add Post to Collection">
              <x-lucide-bookmark class="icon" width="30" height="30" />
            </button>
          </div>
          <a href="{{ URL::route('posts.comments.index', ['post' => $post]) }}" class="level-item button is-primary">
            See Comments
          </a>
        </div>
      </div>
    </x-hero>
    <main class="container is-fluid content mt-5">
      <details class="is-clickable">
        <summary>Metadata</summary>
        <x-metadata.table :metadata="$post->metadata" />
      </details>
      <x-editor model="{{ Js::from($post->body) }}" name="editor" read-only />
      <x-modal show-var='showModal' title="Add to Collection">
        <table class="table is-fullwidth">
          <thead>
            <tr>
              <th>Action</th>
              <th>Collection</th>
            </tr>
          </thead>
          <tbody>
            @foreach (auth()->user()->postCollections as $collection)
              @livewire('add-collection-row', ['collection' => $collection, 'post' => $post], key($collection->id))
            @endforeach
          </tbody>
        </table>
      </x-modal>
    </main>
  </span>
</x-layout>
