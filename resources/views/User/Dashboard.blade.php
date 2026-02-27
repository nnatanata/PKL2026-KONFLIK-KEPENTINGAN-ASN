@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')

<h5 class="fw-bold mb-3">Total Pelaporan</h5>

<div class="row g-3 mb-5">
    <div class="col-md-4">
        <div class="card-box">
            <div class="stat-number stat-diproses">
                {{ $diproses }}
            </div>
            Diproses
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box">
            <div class="stat-number stat-diterima">
                {{ $diterima }}
            </div>
            Disetujui Inspektorat
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box">
            <div class="stat-number stat-ditolak">
                {{ $ditolak }}
            </div>
            Ditolak
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold">Status Terbaru</h5>
    <a href="{{ route('laporan.index') }}" class="lihat-semua">
        Lihat Semua ›
    </a>
</div>

<div class="row g-3 mb-5">
@forelse ($statusTerbaru as $laporan)
    <div class="col-md-4">
        <a href="{{ route('laporan.show', [$laporan->tipe, $laporan->id]) }}"
           class="text-decoration-none text-dark">

            <div class="status-card h-100">
                <h6>{{ $laporan->judul }}</h6>

                @if ($laporan->status === 'Diproses')
                    <span class="badge bg-warning text-dark">Diproses</span>
                @elseif ($laporan->status === 'Disetujui Inspektorat')
                    <span class="badge bg-success">Disetujui</span>
                @elseif ($laporan->status === 'Ditolak Inspektorat')
                    <span class="badge bg-danger">Ditolak</span>
                @endif
            </div>

        </a>
    </div>
@empty
    <div class="col-12">
        <p class="text-muted">Belum ada laporan yang dikirim.</p>
    </div>
@endforelse
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold">Berita Terbaru</h5>
    <a href="#" class="lihat-semua">Lihat Semua ›</a>
</div>

<div class="row g-3 mb-5">
    <div class="col-md-4">
        <div class="news-card">
            <div class="news-thumb"></div>
            <h6>Pencegahan Konflik Kepentingan ASN</h6>
            <small>Update kebijakan terbaru terkait pelaporan konflik kepentingan.</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="news-card">
            <div class="news-thumb"></div>
            <h6>Sosialisasi SIMAKK ASN</h6>
            <small>Pengenalan sistem manajemen konflik kepentingan ASN.</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="news-card">
            <div class="news-thumb"></div>
            <h6>Integritas ASN</h6>
            <small>Langkah strategis menjaga integritas aparatur sipil negara.</small>
        </div>
    </div>
</div>

@endsection