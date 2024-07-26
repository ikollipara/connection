<x-layout title="ConneCTION">
  <x-hero class="is-light" hero-body-class="has-flex has-flex-direction-col ml-5 has-text-centered">
    <h2 class="subtitle is-2 is-italic">
      Learn about CS, together<span class="has-text-primary">.</span>
    </h2>
    <x-logo width="500" height="auto" />
    <p class="container content is-large">
      Connect with teachers all over about Computer Science. Learn from their experiences, share your own.
      This is a community to help <em>You</em> grow!
    </p>
    <div class="buttons is-justify-content-center">
      <a href="{{ route('about') }}" class="button is-primary">About Us</a>
      <a href="{{ route('videos') }}" class="button is-primary is-outlined">Learn More</a>
      <a href="{{ route('users.create') }}" class="button is-primary">Sign Up</a>
    </div>
  </x-hero>
  <x-container class="mt-5">
    <h2 class="title is-1 has-text-centered">
      Connect and Create<span class="has-text-primary">.</span>
    </h2>
    <section class="columns">
      <div class="column is-one-third has-text-centered">
        <x-lucide-newspaper width="50" height="50" />
        <p class="title">Posts</p>
        <p class="content is-medium">
          Showcase your knowledge and ideas through a rich post system. Other teachers can comment,
          like, or even favorite your post.
        </p>
      </div>
      <div class="column is-one-third has-text-centered">
        <x-lucide-message-square width="50" height="50" />
        <p class="title">Comments</p>
        <p class="content is-medium">
          Discuss with a community of interested individuals around posts and collections.
        </p>
      </div>
      <div class="column is-one-third has-text-centered">
        <x-lucide-layers width="50" height="50" />
        <p class="title">Collections</p>
        <p class="content is-medium">
          Collect posts together into something shareable. Whether its for lesson planning or just to
          share, collections allow it all.
        </p>
      </div>
    </section>
  </x-container>
</x-layout>
