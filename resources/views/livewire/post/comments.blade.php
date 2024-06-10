<main>
  <form wire:submit.prevent="save" class="media mx-3 mt-3">
    <figure class="media-left">
      <p class="image is-64x64">
        <img src="{{ auth()->user()->avatar }}" alt="">
      </p>
    </figure>
    <article class="media-content">
      <div class="field">
        <p class="control">
          <textarea wire:model.defer="comment" class="textarea is-primary content is-medium" style="min-height: 5rem;"
            name="" id="" cols="30" rows="10"></textarea>
        </p>
      </div>
      <div class="field">
        <span class="control">
          <button wire:target='save' wire:loading.class='is-loading' class="button is-primary"
            type="submit">Comment</button>
        </span>
      </div>
    </article>
  </form>
  <x-lazy component="container" is-fluid class="mt-5" prop="comments">
    @foreach ($this->comments as $comment)
      <article wire:key='comment-{{ $comment->id }}' class="media">
        <figure class="media-left">
          <p class="image is-64x64">
            <img src="{{ $comment->user->avatar }}" alt="">
          </p>
        </figure>
        <section class="media-content">
          <p class="content is-medium">
            <strong>
              @if ($comment->user)
                {{ $comment->user->full_name }}
              @else
                [Deleted]
              @endif
            </strong>
            <br>
            {{ $comment->body }}
          </p>
          @livewire('like-button', ['likable' => $comment], key('like-button' . $comment->id))
        </section>
      </article>
    @endforeach
    <div class="mt-3 mb-3">
      {{ $this->comments->links('pagination') }}
    </div>
  </x-lazy>
</main>
