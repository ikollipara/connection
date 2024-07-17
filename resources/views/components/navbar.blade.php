<nav class="navbar is-light"
     id="nav"
     x-data="{ active: false }">
  <div class="navbar-brand">
    @auth
      <x-nav.item data-turbo-preload
                  aria-label="Visit the Home Page of conneCTION"
                  route="{{ route('home') }}">
        <x-logo :width="100"
                :height="55" />
      </x-nav.item>
    @else
      <x-nav.item aria-label="Visit your Account's Dashboard"
                  route="{{ route('index') }}">
        <x-logo :width="100"
                :height="55" />
      </x-nav.item>
    @endauth
    <a class="navbar-burger"
       id="hamburger"
       data-target="navbarBasicExample"
       role="button"
       aria-label="menu"
       aria-expanded="false"
       x-on:click="active = !active"
       x-bind:class="{ 'is-active': active }">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>
  <div class="navbar-menu animate__animated"
       id="nav-menu"
       x-bind:class="{ 'is-active': active }">
    <ul class="navbar-start">
      @auth
        <x-nav.dropdown title="My Posts">
          <x-slot name="icon">
            <x-lucide-newspaper class="icon"
                                width="30"
                                height="30" />
          </x-slot>
          <x-nav.item data-turbo-preload
                      route="{{ route('users.posts.index', ['user' => 'me', 'status' => 'draft']) }}">Post
            Drafts</x-nav.item>
          <x-nav.item data-turbo-preload
                      route="{{ route('users.posts.index', ['user' => 'me', 'status' => 'published']) }}">Published
            Posts</x-nav.item>
          <x-nav.item data-turbo-preload
                      route="{{ route('users.posts.index', ['user' => 'me', 'status' => 'archived']) }}">Archived
            Posts</x-nav.item>
          <x-nav.divider />
          <x-nav.item data-turbo-preload
                      route="{{ route('users.posts.create', 'me') }}">Create Post</x-nav.item>
        </x-nav.dropdown>
        <x-nav.dropdown title="My Collections">
          <x-slot name="icon">
            <x-lucide-layers class="icon"
                             width="30"
                             height="30" />
          </x-slot>
          <x-nav.item data-turbo-preload
                      route="{{ route('users.collections.index', ['me', 'status' => 'draft']) }}">
            Collection Drafts
          </x-nav.item>
          <x-nav.item data-turbo-preload
                      route="{{ route('users.collections.index', ['me', 'status' => 'published']) }}">
            Published Collections
          </x-nav.item>
          <x-nav.item data-turbo-preload
                      route="{{ route('users.collections.index', ['me', 'status' => 'archived']) }}">
            Archived Collections
          </x-nav.item>
          <x-nav.divider />
          <x-nav.item data-turbo-preload
                      route="{{ route('users.collections.create', 'me') }}">
            Create Collection
          </x-nav.item>
        </x-nav.dropdown>
      @else
        <x-nav.item route="{{ route('index') }}">Home</x-nav.item>
        <x-nav.item route="{{ route('about') }}">About</x-nav.item>
      @endauth
      <x-nav.item aria-label="A Set of videos describing how to use and interact with connection"
                  route="{{ route('videos') }}">Videos</x-nav.item>
    </ul>
    <ul class="navbar-end">
      @auth
        <x-nav.unsaved-changes />
        <x-nav.item class="icon-text"
                    route="{{ route('faq.index') }}">
          <span class="icon">
            <x-lucide-help-circle class="icon"
                                  width="30"
                                  height="30" />
          </span>
          <span>FAQ/Help</span>
        </x-nav.item>
        <x-nav.item class="icon-text"
                    data-turbo-preload
                    route="{{ route('search') }}">
          <span class="icon">
            <x-lucide-search class="icon"
                             width="30"
                             height="30" />
          </span>
          <span>Search</span>
        </x-nav.item>
        <x-nav.dropdown title="My Profile">
          <x-slot name="icon">
            <x-lucide-user class="icon"
                           width="30"
                           height="30" />
          </x-slot>
          <x-nav.item route="{{ route('users.show', ['user' => auth()->user()]) }}">See My Profile</x-nav.item>
          <x-nav.item route="{{ route('users.profile.edit', 'me') }}">Edit Profile</x-nav.item>
          <x-nav.item route="{{ route('users.settings.edit', 'me') }}">Edit Settings</x-nav.item>
        </x-nav.dropdown>
        <x-nav.avatar />
        <li class="navbar-item">
          <form action="{{ route('login.destroy', auth()->id()) }}"
                method="post">
            @csrf
            @method('DELETE')
            <button class="button is-outlined is-primary icon-text"
                    type="submit"
                    x-on:click="$el.classList.add('is-loading')">
              <span class="icon">
                <x-lucide-log-out class="icon"
                                  width="30"
                                  height="30" />
              </span>
              <span>Logout</span>
            </button>
          </form>
        </li>
      @else
        <x-nav.item class="is-outlined"
                    is-button
                    route="{{ route('users.create') }}">Sign Up</x-nav.item>
        <x-nav.item is-button
                    route="{{ route('login.create') }}">Login</x-nav.item>
      @endauth
    </ul>
  </div>
</nav>
