@props(['step', 'currentStep', 'isFinal' => false])

<section {{ $attributes->except(['step', 'isFinal', 'currentStep']) }}
         x-show="{{ $currentStep }} == {{ $step }}">
  {{ $slot }}
  <div class="field is-group is-grouped-centered">
    <div class="control">
      @if ($step > 0)
        <button class="button is-primary is-outlined"
                type="button"
                x-on:click="{{ $currentStep }}--">
          Back
        </button>
      @endif
      @if ($isFinal)
        <button class="button is-primary"
                type="submit">
          Submit
        </button>
      @else
        <button class="button is-primary"
                type="button"
                x-on:click="{{ $currentStep }}++">
          Next
        </button>
      @endif
    </div>
  </div>
</section>
