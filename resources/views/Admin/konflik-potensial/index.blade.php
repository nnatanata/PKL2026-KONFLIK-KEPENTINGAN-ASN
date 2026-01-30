@extends('admin.layout')

@php
    $hideProfileIcon = true;
@endphp

@section('title', 'Daftar Laporan Konflik Potensial')
@section('breadcrumb', 'Daftar Laporan Konflik Potensial')

@push('styles')
<style>
    /*search dan filter*/
    .toolbar-container {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        display: flex;
        gap: 12px;
        align-items: center;
    }

    /*search bar*/
    .search-wrapper {
        flex: 1;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--main-red);
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    /*buttons */
    .btn-toolbar {
        padding: 10px 20px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        background: white;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .btn-toolbar:hover {
        background: #f8f9fa;
        border-color: var(--main-red);
        color: var(--main-red);
    }

    .btn-toolbar i {
        font-size: 1rem;
    }

    /*filter*/
    .filter-container {
        position: relative;
    }

    .filter-panel {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 8px;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 1000;
        width: 340px;
        display: none;
    }

    .filter-panel.active {
        display: block;
    }

    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f0f0;
    }

    .filter-header h6 {
        margin: 0;
        font-weight: 600;
        font-size: 1rem;
    }

    .filter-reset {
        color: var(--main-red);
        font-size: 0.85rem;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .filter-reset:hover {
        text-decoration: none;
        color: var(--active-red);
    }

    .filter-group {
        margin-bottom: 20px;
    }

    .filter-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .filter-input,
    .filter-select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .filter-input:focus,
    .filter-select:focus {
        outline: none;
        border-color: var(--main-red);
    }

    .filter-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #f0f0f0;
    }

    .btn-filter-action {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-filter-reset {
        background: #f8f9fa;
        color: #495057;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-filter-reset:hover {
        background: #e9ecef;
        text-decoration: none;
    }

    .btn-filter-apply {
        background: var(--main-red);
        color: white;
    }

    .btn-filter-apply:hover {
        background: var(--active-red);
    }

    /*tabel*/
    .table-container {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .table-title {
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
        color: #1e293b;
    }

    .table-title i {
        color: var(--main-red);
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
        font-weight: 600;
        padding: 15px 12px;
        font-size: 0.9rem;
        text-align: center;
        vertical-align: middle;
    }

    .table tbody td {
        padding: 14px 12px;
        vertical-align: middle;
        font-size: 0.9rem;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        cursor: pointer;
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-block;
    }

    .status-disetujui {
        background: #d4edda;
        color: #155724;
    }

    .status-diproses {
        background: #fff3cd;
        color: #856404;
    }

    .status-ditolak {
        background: #f8d7da;
        color: #721c24;
    }

    .btn-action {
        padding: 6px 10px;
        font-size: 0.9rem;
        border-radius: 6px;
        margin: 0 2px;
    }

    .id-cell {
        position: relative;
        cursor: help;
    }

    .id-display {
        font-family: 'Courier New', monospace;
        color: #495057;
        font-weight: 600;
    }

    .id-tooltip {
        position: absolute;
        background: #333;
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.85rem;
        white-space: nowrap;
        z-index: 1000;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 5px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
    }

    .id-tooltip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 5px solid transparent;
        border-top-color: #333;
    }

    .id-cell:hover .id-tooltip {
        opacity: 1;
    }

    /*pagination*/
    .custom-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 20px;
        padding: 15px 0;
    }

    .custom-pagination .page-btn {
        min-width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
        background: white;
        color: #495057;
        text-decoration: none;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s;
        padding: 0 12px;
    }

    .custom-pagination .page-btn:hover {
        background: #f8f9fa;
        border-color: var(--main-red);
        color: var(--main-red);
    }

    .custom-pagination .page-btn.active {
        background: var(--main-red);
        border-color: var(--main-red);
        color: white;
    }

    .custom-pagination .page-btn.disabled {
        opacity: 0.5;
        pointer-events: none;
        cursor: not-allowed;
    }

    .custom-pagination .page-dots {
        color: #6c757d;
        padding: 0 8px;
    }

    .filter-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        width: 8px;
        height: 8px;
        background: var(--main-red);
        border-radius: 50%;
        pointer-events: none;
    }

    .btn-toolbar {
        position: relative;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
        z-index: 999;
        display: none;
    }

    .overlay.active {
        display: block;
    }
</style>
@endpush

@section('content')

{{--overlay--}}
<div class="overlay" id="overlay" onclick="closeAllPanels()"></div>

{{--alert messages --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="toolbar-container">
    {{--search bar--}}
    <div class="search-wrapper">
        <i class="bi bi-search search-icon"></i>
        <input 
            type="text" 
            class="search-input" 
            id="searchInput"
            placeholder="Cari dengan kata kunci Nama Pelapor, Dugaan Konflik, atau Nama Terduga..." 
            value="{{ request('search') }}"
        >
    </div>

    {{--sort button--}}
    <div class="dropdown">
        <button class="btn-toolbar dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-sort-down"></i>
            Sort by
        </button>
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item" href="{{ route('konflik-potensial.index', array_merge(request()->except(['sort_by', 'sort_order']), [])) }}">
                    Clear Sort
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="{{ route('konflik-potensial.index', array_merge(request()->all(), ['sort_by' => 'lp.tanggal_potensial', 'sort_order' => 'desc'])) }}">
                    Tanggal Terbaru
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('konflik-potensial.index', array_merge(request()->all(), ['sort_by' => 'lp.tanggal_potensial', 'sort_order' => 'asc'])) }}">
                    Tanggal Terlama
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('konflik-potensial.index', array_merge(request()->all(), ['sort_by' => 'peg.nama', 'sort_order' => 'asc'])) }}">
                    Nama Pelapor (A-Z)
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('konflik-potensial.index', array_merge(request()->all(), ['sort_by' => 'peg.nama', 'sort_order' => 'desc'])) }}">
                    Nama Pelapor (Z-A)
                </a>
            </li>
        </ul>
    </div>

    {{--filter button --}}
    <div style="position: relative;">
        <button class="btn-toolbar" id="filterBtn" onclick="toggleFilter()">
            <i class="bi bi-funnel"></i>
            Filter
            @if(request('date_from') || request('date_to') || request('status'))
            <span class="filter-badge"></span>
            @endif
        </button>
        <div class="filter-panel" id="filterPanel">
            <div class="filter-header">
                <h6>Filter</h6>
            </div>

            <form id="filterForm" action="{{ route('konflik-potensial.index') }}" method="GET">
                @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                {{--date range --}}
                <div class="filter-group">
                    <label>Date Range</label>
                    <div class="mb-2">
                        <small class="text-muted d-block mb-1">From</small>
                        <input 
                            type="date" 
                            class="filter-input" 
                            name="date_from"
                            value="{{ request('date_from') }}"
                        >
                    </div>
                    <div>
                        <small class="text-muted d-block mb-1">To</small>
                        <input 
                            type="date" 
                            class="filter-input" 
                            name="date_to"
                            value="{{ request('date_to') }}"
                        >
                    </div>
                </div>

                {{--status--}}
                <div class="filter-group">
                    <label>Status</label>
                    <select class="filter-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                {{--actions--}}
                <div class="filter-actions">
                    <a href="{{ route('konflik-potensial.index', request()->only('search')) }}" class="btn-filter-action btn-filter-reset">
                        Reset All
                    </a>
                    <button type="submit" class="btn-filter-action btn-filter-apply">
                        Apply
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="table-container">
    <div class="table-header">
        <h5 class="table-title">
            <i class="bi bi-table me-2"></i>Daftar Laporan ({{ $laporan->total() }} laporan)
        </h5>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 7%">ID</th>
                    <th style="width: 18%">Nama Pelapor</th>
                    <th style="width: 24%">Dugaan Konflik</th>
                    <th style="width: 12%">Tanggal</th>
                    <th style="width: 12%">Status</th>
                    <th style="width: 13%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $item)
                <tr onclick="window.location='{{ route('konflik-potensial.show', $item->id) }}'">
                    <td class="text-center">
                        <div class="id-cell d-inline-block">
                            <span class="id-display">
                                @php
                                    $idStr = (string)$item->id;
                                    if(strlen($idStr) > 3) {
                                        echo '#' . substr($idStr, 0, 3) . '...';
                                    } else {
                                        echo '#' . $idStr;
                                    }
                                @endphp
                            </span>
                            @if(strlen((string)$item->id) > 3)
                            <span class="id-tooltip">#{{ $item->id }}</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $item->nama_pelapor }}</div>
                        <small class="text-muted">{{ $item->username_pelapor }}</small>
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $item->dugaan_konflik }}</div>
                        <small class="text-muted">Terduga: {{ $item->nama_terduga }}</small>
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_potensial)->format('d M Y') }}</td>
                    <td class="text-center">
                        <span class="badge-status 
                            {{ $item->status_potensial == 'Disetujui' ? 'status-disetujui' : '' }}
                            {{ $item->status_potensial == 'Diproses' ? 'status-diproses' : '' }}
                            {{ $item->status_potensial == 'Ditolak' ? 'status-ditolak' : '' }}
                        ">
                            {{ $item->status_potensial }}
                        </span>
                    </td>
                    <td class="text-center" onclick="event.stopPropagation()">
                        <a href="{{ route('konflik-potensial.show', $item->id) }}" 
                           class="btn btn-sm btn-action btn-outline-primary" 
                           title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <form action="{{ route('konflik-potensial.destroy', $item->id) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-sm btn-action btn-outline-danger" 
                                    title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        <p class="mb-0">Tidak ada data laporan ditemukan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{--pagination--}}
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
</div>

@endsection

@push('scripts')
<script>
    function toggleFilter() {
        const filterPanel = document.getElementById('filterPanel');
        const overlay = document.getElementById('overlay');
        
        const isActive = filterPanel.classList.toggle('active');
        overlay.classList.toggle('active', isActive);
    }

    function closeAllPanels() {
        const filterPanel = document.getElementById('filterPanel');
        const overlay = document.getElementById('overlay');
        
        if (filterPanel) {
            filterPanel.classList.remove('active');
        }
        overlay.classList.remove('active');
    }

    const searchInput = document.getElementById('searchInput');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const url = new URL(window.location.href);
            if (this.value) {
                url.searchParams.set('search', this.value);
            } else {
                url.searchParams.delete('search');
            }
            window.location.href = url.toString();
        }, 500);
    });

    document.addEventListener('click', function(event) {
        const filterBtn = document.getElementById('filterBtn');
        const filterPanel = document.getElementById('filterPanel');
        
        if (filterBtn && filterPanel && 
            !filterBtn.contains(event.target) && 
            !filterPanel.contains(event.target)) {
            filterPanel.classList.remove('active');
            document.getElementById('overlay').classList.remove('active');
        }
    });
</script>
@endpush