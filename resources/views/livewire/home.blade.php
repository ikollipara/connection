<div>
  @push('meta')
    <meta name="turbolinks-visit-control" content="reload">
  @endpush
  <x-hero class="is-primary">
    <h1 class="title">Welcome to conneCTION</h1>
  </x-hero>
  <x-container x-data="{ tab: 0 }" is-fluid class="mt-5">
    <x-tabs tab-titles="Top Posts, Top Collections, Your Follower Feed">
      <x-tabs.tab component="lazy" prop="top_posts" title="Top Posts">
        <table class="table is-fullwidth">
          <tbody>
            @foreach ($this->topPosts as $post)
              <x-search.row :item="$post" />
            @endforeach
          </tbody>
        </table>
      </x-tabs.tab>
      <x-tabs.tab component="lazy" prop="top_collections" title="Top Collections">
        <table class="table is-fullwidth">
          <tbody>
            @foreach ($this->topCollections as $collection)
              <x-search.row :item="$collection" />
            @endforeach
          </tbody>
        </table>
      </x-tabs.tab>
      <x-tabs.tab component="lazy" prop="followings_items" title="Your Follower Feed">
        <table class="table is-fullwidth">
          <tbody>
            @forelse ($this->followingsItems as $item)
              <x-search.row :item="$item" />
            @empty
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
            @endforelse
          </tbody>
        </table>
      </x-tabs.tab>
    </x-tabs>
    </x-bulma.container>
</div>
