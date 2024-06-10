<x-layout title="conneCTION - {{ $collection->title }}">
  <x-hero class="is-primary">
    <h1 class="title is-1 has-text-centered">{{ $collection->title }}</h1>
    <div class="is-flex is-flex-direction-column mb-2 is-align-items-center is-justify-content-center has-text-centered"
      style="gap: 0.5rem;">
      <figure class="image is-64x64 is-flex is-justify-content-center is-align-items-center">
        <img style="width: 50px; height: 50px; object-fit:cover;" class="is-rounded" src="{{ $collection->user->avatar }}"
          alt="">
      </figure>
      @if ($collection->user)
        <a href="{{ route('users.show', ['user' => $collection->user]) }}" class="link is-italic">
          {{ $collection->user->full_name }} - {{ $collection->user->profile->short_title }}
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
            <span>{{ $collection->views }}</span>
          </p>
        </div>
        <div class="level-item">
          @livewire('like-button', ['likable' => $collection])
        </div>
      </div>
      <div class="level-right">
        <a href="{{ URL::route('collections.comments.index', ['post_collection' => $collection]) }}"
          class="level-item button is-primary">
          See Comments
        </a>
      </div>
    </div>
  </x-hero>
  <main x-data="{ tab: 0 }" class="container is-fluid content mt-5">
    <x-tabs tab-titles="Description, Entries">
      <x-tabs.tab title="Description">
        <details class="is-clickable">
          <summary>Metadata</summary>
          <x-metadata.table :metadata="$collection->metadata" />
        </details>
        <section>
          <x-editor value='{{ Js::from($collection->body) }}' name="editor" read-only />
        </section>
      </x-tabs.tab>
      <x-tabs.tab title="Entries">
        <table class="table is-fullwidth">
          <thead>
            <tr>
              <th>Title</th>
              <th>Author</th>
              <th>Link</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($collection->entries as $post)
              <tr>
                <td>{{ $post->title }}</td>
                <td>
                  @if ($post->user)
                    {{ $post->user->full_name }}
                  @else
                    [Deleted]
                  @endif
                </td>
                <td><a href="{{ URL::route('posts.show', ['post' => $post]) }}">Visit</a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </x-tabs.tab>
    </x-tabs>
  </main>
</x-layout>
