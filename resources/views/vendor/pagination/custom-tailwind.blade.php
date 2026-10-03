
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        <div class="flex items-center gap-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-2 py-1 text-xs font-medium text-slate-400 bg-white border border-slate-300 cursor-default rounded-md">
                    &laquo;
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-1 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-md hover:bg-slate-50 focus:z-10 focus:outline-none focus:ring ring-brand-300 focus:border-brand-300 active:bg-slate-100 active:text-slate-700 transition ease-in-out duration-150">
                    &laquo;
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="relative inline-flex items-center px-2 py-1 text-xs font-medium text-slate-700 bg-white border border-slate-300 cursor-default rounded-md">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="relative inline-flex items-center px-2.5 py-1 text-xs font-bold text-white bg-brand-600 border border-brand-600 cursor-default rounded-md">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="relative inline-flex items-center px-2.5 py-1 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-md hover:bg-slate-50 focus:z-10 focus:outline-none focus:ring ring-brand-300 focus:border-brand-300 active:bg-slate-100 active:text-slate-700 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-1 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-md hover:bg-slate-50 focus:z-10 focus:outline-none focus:ring ring-brand-300 focus:border-brand-300 active:bg-slate-100 active:text-slate-700 transition ease-in-out duration-150">
                    &raquo;
                </a>
            @else
                <span class="relative inline-flex items-center px-2 py-1 text-xs font-medium text-slate-400 bg-white border border-slate-300 cursor-default rounded-md">
                    &raquo;
                </span>
            @endif
        </div>
    </nav>
@endif

