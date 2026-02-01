@extends('layouts.user')

@section('title', 'Status Laporan')

@section('content')
<h5 class="fw-bold mb-4">Status Laporan</h5>

<div class="row g-4">
    @forelse ($laporan as $item)
        <div class="col-md-4">
            <div class="status-card h-100">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge 
                        {{ $item->tipe === 'Aktual' ? 'bg-danger' : 'bg-secondary' }}">
                        {{ $item->tipe }}
                    </span>

                    @if ($item->status === 'Diproses')
                        <span class="badge bg-warning text-dark">Diproses</span>
                    @elseif ($item->status === 'Diterima')
                        <span class="badge bg-success">Diterima</span>
                    @elseif ($item->status === 'Ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </div>

                <h6 class="fw-semibold">
                    {{ $item->judul }}
                </h6>

                <small class="text-muted">
                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                </small>
            </div>
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
