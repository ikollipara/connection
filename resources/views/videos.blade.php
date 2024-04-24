<x-layout title="conneCTION - Video Series">
  <x-hero class="is-primary">
    <h1 class="title is-1">What is conneCTION?</h1>
    <p class="subtitle">
      Want a fuller understanding of conneCTION? Check out these videos made by the main developer himself, Ian
      Kollipara!
    </p>
  </x-hero>
  <main x-data="{ currentStep: 0 }" class="container">
    <section class="level" x-show="currentStep == 0">
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
    </section>
    <section class="level" x-show="currentStep == 1">
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
    </section>
    <section class="level" x-show="currentStep == 2">
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
    </section>
    <section class="level" x-show="currentStep == 3">
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
    </section>
    <section class="level" x-show="currentStep == 4">
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
    </section>
    <section class="level" x-show="currentStep == 5">
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
    </section>
  </main>
</x-layout>
