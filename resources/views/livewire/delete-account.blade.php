<span x-data='{showModal: false}'>
  <button @@click='showModal = true' type="button" class="button is-danger">
    Delete Account
  </button>

  <form wire:submit.prevent='destroy' method="post">

    <div class="modal" x-bind:class='{ "is-active": showModal }'>
      <div @@click="showModal = false" class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Delete Account?</p>
          <button type="button" class="delete" wire:loading.attr='disabled' wire:target='destroy'
            @@click="showModal = false" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <button @@click="showModal = false" type="button" wire:loading.attr='disabled'
            wire:target='destroy' class="button is-danger is-outlined">Cancel</button>
          <button wire:loading.class='is-loading' wire:loading.attr='disabled' wire:target='destroy' type="submit"
            class="button is-danger">Delete</button>
        </section>
      </div>
    </div>
  </form>
</span>
