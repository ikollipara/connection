@props(['route', 'isButton' => false])
@if ($isButton)
  <li class="navbar-item">
    <a href="{{ $route }}"
       {{ $attributes->merge(['class' => 'button is-primary']) }}>
      {{ $slot }}
    </a>
  </li>
@else
  <a href="{{ $route }}"
     {{ $attributes->merge(['class' => 'navbar-item']) }}>
    {{ $slot }}
  </a>
@endif
