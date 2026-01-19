@if ($paginator->hasPages())
    <ul class="pagination flex flex-wrap items-center gap-2 justify-end mt-4">
        {{-- First Page Link --}}
        @if (!$paginator->onFirstPage())
            <li class="page-item">
                <a href="{{ $paginator->url(1) }}" class="page-link bg-white dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-600 text-secondary-light font-medium rounded-lg px-4 py-2 flex items-center justify-center h-[40px]">First</a>
            </li>
        @endif

        {{-- Previous Page Link --}}
        <li class="page-item">
            @if ($paginator->onFirstPage())
                <span class="page-link bg-neutral-100 text-neutral-400 rounded-lg px-4 py-2 h-[40px] flex items-center justify-center">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link bg-white dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-600 text-secondary-light font-medium rounded-lg px-4 py-2 flex items-center justify-center h-[40px]">Previous</a>
            @endif
        </li>

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Dots --}}
            @if (is_string($element))
                <span class="px-3 py-2 text-neutral-400">{{ $element }}</span>
            @endif

            {{-- Array of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item">
                            <span class="page-link border-primary-400 text-primary-600 bg-white dark:bg-neutral-700 rounded-lg px-4 py-2 flex items-center justify-center h-[40px] w-[40px]">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $url }}" class="page-link bg-white dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-600 text-secondary-light font-medium rounded-lg px-4 py-2 flex items-center justify-center h-[40px] w-[40px]">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        <li class="page-item">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link bg-white dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-600 text-secondary-light font-medium rounded-lg px-4 py-2 flex items-center justify-center h-[40px]">Next</a>
            @else
                <span class="page-link bg-neutral-100 text-neutral-400 rounded-lg px-4 py-2 h-[40px] flex items-center justify-center">Next</span>
            @endif
        </li>

        {{-- Last Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a href="{{ $paginator->url($paginator->lastPage()) }}" class="page-link bg-white dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-600 text-secondary-light font-medium rounded-lg px-4 py-2 flex items-center justify-center h-[40px]">Last</a>
            </li>
        @endif
    </ul>
@endif
