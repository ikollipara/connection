<x-layout title="conneCTION - Video Series">
  <x-hero class="is-primary">
    <h1 class="title is-1">What is conneCTION?</h1>
    <p class="subtitle">
      Want a fuller understanding of conneCTION? Check out these videos made by the main developer himself, Ian
      Kollipara!
    </p>
  </x-hero>
  <main x-data="{ currentStep: 0 }" class="container">
    <section x-show="currentStep == 0">
      <h2 class="title is-3">Episode 1 - Searching</h2>
      <div class="level">
        <button disabled class="button is-primary" title="Next">
          <x-lucide-chevron-left width="50" height="50" />
        </button>
        <div class="mx-4 my-4">
          <video controls>
            <source src="/storage/episodes/Episode-1-Searching.mp4" encoding="video/mp4">
          </video>
        </div>
        <button x-on:click="currentStep++" class="button is-primary" title="Next">
          <x-lucide-chevron-right width="50" height="50" />
        </button>
      </div>
    </section>
    <section x-show="currentStep == 1">
      <h2 class="title is-3">Episode 2 - Collections</h2>
      <div class="level">
        <button x-on:click="currentStep--" class="button is-primary" title="Next">
          <x-lucide-chevron-left width="50" height="50" />
        </button>
        <div class="mx-4 my-4">
          <video controls>
            <source src="/storage/episodes/Episode-2-Collections.mp4" encoding="video/mp4">
          </video>
        </div>
        <button x-on:click="currentStep++" class="button is-primary" title="Next">
          <x-lucide-chevron-right width="50" height="50" />
        </button>
      </div>
    </section>
    <section x-show="currentStep == 2">
      <h2 class="title is-3">Episode 3 - How to Follow and Comment</h2>
      <div class="level">
        <button x-on:click="currentStep--" class="button is-primary" title="Next">
          <x-lucide-chevron-left width="50" height="50" />
        </button>
        <div class="mx-4 my-4">
          <video controls>
            <source src="/storage/episodes/Episode-3-How-to-Follow-and-Comment.mp4" encoding="video/mp4">
          </video>
        </div>
        <button x-on:click="currentStep++" class="button is-primary" title="Next">
          <x-lucide-chevron-right width="50" height="50" />
        </button>
      </div>
    </section>
    <section x-show="currentStep == 3">
      <h2 class="title is-3">Episode 4 - Posts</h2>
      <div class="level">
        <button x-on:click="currentStep--" class="button is-primary" title="Next">
          <x-lucide-chevron-left width="50" height="50" />
        </button>
        <div class="mx-4 my-4">
          <video controls>
            <source src="/storage/episodes/Episode-4-Posts.mp4" encoding="video/mp4">
          </video>
        </div>
        <button x-on:click="currentStep++" class="button is-primary" title="Next">
          <x-lucide-chevron-right width="50" height="50" />
        </button>
      </div>
    </section>
    <section x-show="currentStep == 4">
      <h2 class="title is-3">Episode 5 - Profiles</h2>
      <div class="level">
        <button x-on:click="currentStep--" class="button is-primary" title="Next">
          <x-lucide-chevron-left width="50" height="50" />
        </button>
        <div class="mx-4 my-4">
          <video controls>
            <source src="/storage/episodes/Episode-5-Profiles.mp4" encoding="video/mp4">
          </video>
        </div>
        <button x-on:click="currentStep++" class="button is-primary" title="Next">
          <x-lucide-chevron-right width="50" height="50" />
        </button>
      </div>
    </section>
    <section x-show="currentStep == 5">
      <h2 class="title is-3">Episode 6 - Goals</h2>
      <div class="level">
        <button x-on:click="currentStep--" class="button is-primary" title="Next">
          <x-lucide-chevron-left width="50" height="50" />
        </button>
        <div class="mx-4 my-4">
          <video controls>
            <source src="/storage/episodes/Episode-6-Goals.mp4" encoding="video/mp4">
          </video>
        </div>
        <button disabled class="button is-primary" title="Next">
          <x-lucide-chevron-right width="50" height="50" />
        </button>
      </div>
    </section>
  </main>
</x-layout>
