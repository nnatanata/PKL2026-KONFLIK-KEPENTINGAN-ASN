@if($laporan->hasPages())
<div class="custom-pagination">
    @if ($laporan->onFirstPage())
        <span class="page-btn disabled">
            <i class="bi bi-chevron-left"></i>
        </span>
    @else
        <a href="{{ $laporan->previousPageUrl() }}" class="page-btn">
            <i class="bi bi-chevron-left"></i>
        </a>
    @endif

    @php
        $currentPage = $laporan->currentPage();
        $lastPage = $laporan->lastPage();
        $start = max(1, $currentPage - 1);
        $end = min($lastPage, $currentPage + 1);
    @endphp

    @if($start > 1)
        <a href="{{ $laporan->url(1) }}" class="page-btn">1</a>
        @if($start > 2)
            <span class="page-dots">...</span>
        @endif
    @endif

    @for ($i = $start; $i <= $end; $i++)
        @if ($i == $currentPage)
            <span class="page-btn active">{{ $i }}</span>
        @else
            <a href="{{ $laporan->url($i) }}" class="page-btn">{{ $i }}</a>
        @endif
    @endfor

    @if($end < $lastPage)
        @if($end < $lastPage - 1)
            <span class="page-dots">...</span>
        @endif
        <a href="{{ $laporan->url($lastPage) }}" class="page-btn">{{ $lastPage }}</a>
    @endif

    @if ($laporan->hasMorePages())
        <a href="{{ $laporan->nextPageUrl() }}" class="page-btn">Next</a>
    @else
        <span class="page-btn disabled">Next</span>
    @endif
</div>
@endif