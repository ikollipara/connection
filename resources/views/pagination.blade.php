<div>
  @if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="pagination">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <a class="pagination-previous is-disabled">
          {!! __('pagination.previous') !!}
        </a>
      @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-previous">
          {!! __('pagination.previous') !!}
        </a>
      @endif

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-next">
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
