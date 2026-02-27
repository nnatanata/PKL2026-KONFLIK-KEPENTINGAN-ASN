<div class="toolbar-container">
    {{--search bar--}}
    <div class="search-wrapper">
        <i class="bi bi-search search-icon"></i>
        <input 
            type="text" 
            class="search-input" 
            id="searchInput"
            placeholder="{{ $searchPlaceholder }}" 
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
                <a class="dropdown-item" href="{{ route($routeName . '.index', array_merge(request()->except(['sort_by', 'sort_order']), [])) }}">
                    Clear Sort
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="{{ route($routeName . '.index', array_merge(request()->all(), ['sort_by' => $sortByDate, 'sort_order' => 'desc'])) }}">
                    Tanggal Terbaru
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route($routeName . '.index', array_merge(request()->all(), ['sort_by' => $sortByDate, 'sort_order' => 'asc'])) }}">
                    Tanggal Terlama
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route($routeName . '.index', array_merge(request()->all(), ['sort_by' => 'peg.nama', 'sort_order' => 'asc'])) }}">
                    Nama Pelapor (A-Z)
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route($routeName . '.index', array_merge(request()->all(), ['sort_by' => 'peg.nama', 'sort_order' => 'desc'])) }}">
                    Nama Pelapor (Z-A)
                </a>
            </li>
        </ul>
    </div>

    {{--filter button--}}
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

            <form id="filterForm" action="{{ route($routeName . '.index') }}" method="GET">
                @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                {{--date range--}}
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
                    <a href="{{ route($routeName . '.index', request()->only('search')) }}" class="btn-filter-action btn-filter-reset">
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