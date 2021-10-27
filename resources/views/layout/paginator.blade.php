@if ($paginator->hasPages())
<nav>
    <ul class="pagination btn-group">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
            <span aria-hidden="true"><button class="btn btn-light" disabled><i
                        class="mdi mdi-skip-previous-circle"></i></button></span>
        </li>
        @else
        <li class="page-item">
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><button
                    class="btn btn-warning"><i class="mdi mdi-skip-previous-circle"></i></button></i></a>
        </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="page-item active" aria-current="page"><span><button class="btn btn-light" disabled>{{ $page
                    }}</button></span></li>
        @else
        <li class="page-item"><a href="{{ $url }}"><button class="btn btn-primary">{{ $page
                    }}</button></a></li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page-item">
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><button
                    class="btn btn-warning"><i class="mdi mdi-skip-next-circle"></i></button></a>
        </li>
        @else
        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
            <span aria-hidden="true"><button class="btn btn-light" disabled><i
                        class="mdi mdi-skip-next-circle"></i></button></span>
        </li>
        @endif
    </ul>
</nav>
@endif