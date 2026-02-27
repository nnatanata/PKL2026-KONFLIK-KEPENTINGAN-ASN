@extends('verifikator.layout')

@php
    $hideProfileIcon = true;
@endphp

@section('title', 'Daftar Laporan Konflik Potensial')
@section('breadcrumb', 'Daftar Laporan Konflik Potensial')

@push('styles')
@include('verifikator.partials.styles.table-list-styles')
@endpush

@section('content')

{{--overlay--}}
<div class="overlay" id="overlay" onclick="closeAllPanels()"></div>

{{--alert messages--}}
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

@include('verifikator.partials.components.toolbar', [
    'searchPlaceholder' => 'Cari dengan kata kunci Nama Pelapor, Dugaan Konflik, atau Nama Terduga...',
    'routeName' => 'konflik-potensial',
    'sortByDate' => 'lp.tanggal_potensial'
])

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
                        <div class="status-badge-container">
                            @if($item->status_inspektorat == 'Disetujui Inspektorat')
                                <span class="badge-status status-disetujui-inspektorat">
                                    <i class="bi bi-check-circle-fill me-1"></i>Disetujui Inspektorat
                                </span>
                            @elseif($item->status_inspektorat == 'Ditolak Inspektorat')
                                <span class="badge-status status-ditolak-inspektorat">
                                    <i class="bi bi-x-circle-fill me-1"></i>Ditolak Inspektorat
                                </span>
                            @else
                                @if($item->status_potensial == 'Disetujui')
                                    <span class="badge-status status-disetujui">Disetujui</span>
                                @elseif($item->status_potensial == 'Diproses')
                                    <span class="badge-status status-diproses">Diproses</span>
                                @elseif($item->status_potensial == 'Ditolak')
                                    <span class="badge-status status-ditolak">Ditolak</span>
                                @else
                                    <span class="badge-status">{{ $item->status_potensial }}</span>
                                @endif
                            @endif
                        </div>
                    </td>
                    <td class="text-center" onclick="event.stopPropagation()">
                        <a href="{{ route('konflik-potensial.show', $item->id) }}" 
                        class="btn btn-sm btn-action btn-outline-primary" 
                        title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <button type="button" 
                                class="btn btn-sm btn-action btn-outline-danger" 
                                title="Hapus"
                                onclick="confirmDelete('{{ $item->id }}', '{{ $item->nama_pelapor }}')">
                            <i class="bi bi-trash"></i>
                        </button>
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

    @include('verifikator.partials.components.pagination', ['laporan' => $laporan])
</div>

@include('verifikator.partials.components.delete-modal')

@endsection

@push('scripts')
@include('verifikator.partials.scripts.table-list-scripts', ['deleteRoute' => '/konflik-potensial'])
@endpush