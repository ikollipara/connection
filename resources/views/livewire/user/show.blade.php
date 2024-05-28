<div>
  <x-hero class="is-primary">
    <div class="is-flex" style="gap: 1rem;">
      <figure class="image is-128x128 mt-auto mb-auto">
        <img loading="lazy" src="{{ $this->user->avatar() }}" alt="">
      </figure>
      <div class="is-flex is-flex-direction-column">
        <h1 class="title is-1">{{ $this->user->full_name() }}</h1>
        <div class="is-flex is-justify-content-start is-align-items-center" style="gap: 1em;">
          <a href="{{ route('users.followers.index', ['user' => $this->user]) }}"
            class="is-link">{{ $this->user->followers_count }} Followers</a>
          <a href="{{ route('users.followings.index', ['user' => $this->user]) }}"
            class="is-link">{{ $this->user->following_count }} Following</a>
        </div>
        <p class="is-italic content">
          {{ $this->user->subject }} Teacher at
          {{ $this->user->school }}
        </p>
        <div class="buttons">
          @unless (auth()->user()->is($this->user))
            @if (auth()->user()->hasFollowed($this->user))
              <button wire:target='unfollow' wire:loading.class='is-loading' wire:click='unfollow("{{ auth()->id() }}")'
                type="button" class="button is-success icon-text is-justify-content-start">
                <span class="icon">
                  <x-lucide-star class="icon" width="30" height="30" fill="white" />
                </span>
                <span class="mt-auto mb-auto">Unfollow</span>
              </button>
            @else
              <button wire:target='follow' wire:loading.class='is-loading' wire:click='follow("{{ auth()->id() }}")'
                type="button" class="button is-success icon-text is-justify-content-start">
                <span class="icon">
                  <x-lucide-star class="icon" width="30" height="30" />
                </span>
                <span class="mt-auto mb-auto">Follow</span>
              </button>
            @endif
          @endunless
          <a href="{{ route('users.posts.index', ['user' => $this->user]) }}"
            class="button is-link icon-text is-justify-content-start">
            <span class="icon">
              <x-lucide-newspaper class="icon" width="30" height="30" />
            </span>
            <span class="mt-auto mb-auto">See All Posts</span>
          </a>
          <a href="{{ route('users.collections.index', ['user' => $this->user]) }}"
            class="button is-link icon-text is-justify-content-start">
            <span class="icon">
              <x-lucide-layers class="icon" width="30" height="30" />
            </span>
            <span class="mt-auto mb-auto">See All Collections</span>
          </a>
        </div>
      </div>
    </div>
  </x-hero>
  <x-container is-fluid class="mt-5">
    <x-tabs tab-titles="Biography, Top Posts, Top Collections">
      <x-tabs.tab title="Biography">
        <x-editor read-only wire:model='bio' name="bio" />
      </x-tabs.tab>
      <x-tabs.tab component="lazy" prop="posts" title="Top Posts">
        <table class="table is-fullwidth">
          <tbody>
            @foreach ($this->topPosts as $post)
              <x-search.row :item="$post" :show-user="false" />
            @endforeach
          </tbody>
        </table>
      </x-tabs.tab>
      <x-tabs.tab component="lazy" prop="collections" title="Top Collections">
        <table class="table is-fullwidth">
          <tbody>
            @foreach ($this->topCollections as $collection)
              <x-search.row :item="$collection" :show-user="false" />
            @endforeach
          </tbody>
        </table>
      </x-tabs.tab>
    </x-tabs>
  </x-container>
</div>
