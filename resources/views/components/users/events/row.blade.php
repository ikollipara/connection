    

<tr class="is-clickable" x-data x-on:click="window.location.href = '{{ route('users.events.edit', ['me', $item]) }}'">
  <td>
    {{ $item->title }}
  </td>
  @if (is_null($item->end_date))
    <td>{{ $item->start_date->formatLocalized('%B %d') }}</t>
    @else
    <td>{{ $item->start_date->formatLocalized('%B %d') }} to {{$item->end_date->formatLocalized('%B %d')}} </td>
  @endif
    
  <td class="buttons mb-0">
    @if ($item->published)
      <a href="{{ route('users.events.edit', $item) }}" class="button is-primary">
        <x-lucide-arrow-right class="icon" width="30" height="30" fill="none" />
      </a>
    @endif
    <form action="{{ route('users.events.index', ['me', $item]) }}" method="get">
      @csrf
      <input type="hidden" name="archive" value="{{ $item->trashed() ? '0' : '1' }}">
      <button type="submit" >Attend Event
      </button>
    </form>
  </td>
</tr>
