@if ($paginator->hasPages())
    <ul class="uk-list uk-text-lead uk-text-center" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="uk-display-inline-block uk-padding-small-right" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="uk-text" aria-hidden="true">&lsaquo;</span>
            </li>
        @else
            <li class="uk-display-inline-block uk-padding-small-right">
                <a class="uk-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="uk-display-inline-block" aria-disabled="true"><span class="uk-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="uk-display-inline-block uk-active" aria-current="page"><span class="uk-active">{{ $page }}</span></li>
                    @else
                        <li class="uk-display-inline-block"><a class="uk-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="uk-display-inline-block uk-padding-small-left">
                <a class="uk-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
            </li>
        @else
            <li class="uk-display-inline-block uk-padding-small-left" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="" aria-hidden="true">&rsaquo;</span>
            </li>
        @endif
    </ul>
@endif
