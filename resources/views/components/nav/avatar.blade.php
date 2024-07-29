<li class="navbar-item">
  <figure class="image is-32x32">
    <img src="{{ auth()->user()->avatar }}"
         alt=""
         @@avatar-updated.document="$el.src = $event.detail.url">
  </figure>
</li>
