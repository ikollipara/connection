@props(['label', 'name', 'showText' => true])

<section class="field">
  <div class="control">
    <label class="label"
           for="{{ $name }}">{{ $label }}</label>
  </div>
  <div class="control"
       x-data="{ filename: '' }">
    <div class="file has-name is-boxed">
      <label class="file-label">
        <input class="file-input"
               id=""
               name="{{ $name }}"
               type="file"
               {{ $attributes }}
               x-on:change="filename = $event.target.files[0].name"
               accept="image/*">
        <span class="file-cta">
          <span class="file-icon">
            <x-lucide-upload width="50"
                             height="50" />
          </span>
          <span class="file-label">
            Choose a file...
          </span>
        </span>
        <span class="file-name"
              @if ($showText) hidden @endif
              x-text="filename"></span>
      </label>
    </div>

  </div>
</section>
