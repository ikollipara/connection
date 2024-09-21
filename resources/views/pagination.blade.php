<div>
  @if ($paginator->hasPages())
    <nav class="pagination"
         role="navigation"
         aria-label="Pagination Navigation">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <a class="pagination-previous is-disabled">
          {!! __('pagination.previous') !!}
        </a>
      @else
        <a class="pagination-previous"
           href="{{ $paginator->previousPageUrl() }}"
           rel="prev">
          {!! __('pagination.previous') !!}
        </a>
      @endif

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <a class="pagination-next"
           href="{{ $paginator->nextPageUrl() }}"
           rel="next">
          {!! __('pagination.next') !!}
        </a>
      @else
        <a class="pagination-next is-disabled">
          {!! __('pagination.next') !!}
        </a>
      @endif
    </nav>
  @endif
</div>
