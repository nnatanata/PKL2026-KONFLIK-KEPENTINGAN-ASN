@extends('inspektorat.layout')

@php
    $hideProfileIcon = true;
@endphp

@section('title', 'Daftar Laporan Konflik Aktual')
@section('breadcrumb', 'Daftar Laporan Konflik Aktual')

@push('styles')
@include('inspektorat.partials.styles.table-list-styles')
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

@include('inspektorat.partials.components.toolbar', [
    'searchPlaceholder' => 'Cari dengan kata kunci Nama Pelapor, Sumber Konflik, atau Nama Pelaku...',
    'routeName' => 'inspektorat.konflik-aktual',
    'sortByDate' => 'la.tanggal_aktual'
])

<div class="table-container">
    <div class="table-header">
        <h5 class="table-title">
            <i class="bi bi-table me-2"></i>Daftar Laporan ({{ $laporan->total() }} laporan)
        </h5>
        <a href="{{ route('inspektorat.konflik-aktual.export', request()->all()) }}" 
           class="btn-export">
            <i class="bi bi-file-earmark-spreadsheet"></i>
            Export Excel
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 7%">ID</th>
                    <th style="width: 18%">Nama Pelapor</th>
                    <th style="width: 24%">Sumber Konflik</th>
                    <th style="width: 12%">Tanggal</th>
                    <th style="width: 12%">Status</th>
                    <th style="width: 13%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $item)
                <tr onclick="window.location='{{ route('inspektorat.konflik-aktual.show', $item->id) }}'">
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
                        <div class="fw-semibold">{{ $item->sumber_konflik }}</div>
                        <small class="text-muted">Pelaku: {{ $item->nama_pelaku }}</small>
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_aktual)->format('d M Y') }}</td>
                    <td class="text-center">
                        <span class="badge-status 
                            {{ $item->status_aktual == 'Disetujui' ? 'status-disetujui-verifikator' : '' }}
                            {{ $item->status_aktual == 'Disetujui Inspektorat' ? 'status-disetujui-inspektorat' : '' }}
                            {{ $item->status_aktual == 'Ditolak Inspektorat' ? 'status-ditolak' : '' }}
                        ">
                            {{ $item->status_aktual == 'Disetujui' ? 'Disetujui Verifikator' : $item->status_aktual }}
                        </span>
                    </td>
                    <td class="text-center" onclick="event.stopPropagation()">
                        <a href="{{ route('inspektorat.konflik-aktual.show', $item->id) }}" 
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

    @include('inspektorat.partials.components.pagination', ['laporan' => $laporan])
</div>

@include('inspektorat.partials.components.delete-modal')

@endsection

@push('scripts')
@include('inspektorat.partials.scripts.table-list-scripts', ['deleteRoute' => '/inspektorat/konflik-aktual'])
@endpush