@extends('layouts.user')

@php
use Illuminate\Support\Str;
@endphp

@section('title', 'Status Laporan')

@section('content')
<h5 class="fw-bold mb-4">Status Laporan</h5>

<div class="row g-4">
    @forelse ($laporan as $item)
        <div class="col-md-4">
            <a href="{{ route('laporan.show', [$item->tipe === 'Aktual' ? 'aktual' : 'potensial', $item->id]) }}"
            class="text-decoration-none text-dark">
                <div class="status-card h-100">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge 
                            {{ $item->tipe === 'Aktual' ? 'bg-danger' : 'bg-secondary' }}">
                            {{ $item->tipe }}
                        </span>

                        @php
                            $status = $item->status;
                        @endphp
                        @if ($status === 'Disetujui')
                            {{-- verifikator has approved, still in process until inspektorat --}}
                            <span class="badge bg-warning text-dark">Diproses</span>
                        @elseif ($status === 'Diproses')
                            <span class="badge bg-warning text-dark">Diproses</span>
                        @elseif ($status === 'Disetujui Inspektorat')
                            <span class="badge bg-success">Disetujui</span>
                        @elseif ($status === 'Ditolak Inspektorat' || $status === 'Ditolak')
                            <span class="badge bg-danger">{{ $status }}</span>
                        @endif
                    </div>

                    <h6 class="fw-semibold">
                        {{ $item->judul }}
                    </h6>

                    <small class="text-muted">
                        {{ \Carbon\Carbon::parse($item->waktu)->format('d M Y H:i') }}
                    </small>
                </div>
            </a>
        </div>
    @empty
        <div class="col-12">
            <p class="text-muted">Belum ada laporan.</p>
        </div>
    @endforelse
</div>

<div class="mt-5 d-flex justify-content-center">
    {{ $laporan->links('pagination::bootstrap-5') }}
</div>
@endsection