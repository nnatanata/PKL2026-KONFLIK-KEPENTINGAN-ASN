@extends('layouts.user')
@section('title', 'Detail Laporan Aktual')

@section('content')
<h5 class="fw-bold mb-4">Detail Laporan Aktual</h5>

<style>
.status-timeline{display:flex;justify-content:space-between;position:relative;margin:32px 0;padding:4px 20px 20px 20px;}
.status-timeline::before{content:'';position:absolute;top:16px;left:20px;right:20px;height:4px;background:#e0e0e0;z-index:1;}
.status-item{position:relative;text-align:center;flex:1;padding-top:8px;}
.status-item .circle{width:32px;height:32px;border-radius:50%;background:#e0e0e0;margin:0 auto;display:flex;align-items:center;justify-content:center;transition:background 0.3s;color:transparent;font-weight:bold;font-size:18px;position:relative;z-index:2;}
.status-item.active .circle{background:#28a745;color:#fff;}
.status-item.rejected .circle{background:#dc3545;color:#fff;}
.status-item .label{margin-top:8px;font-size:13px;font-weight:600;}
.status-item .time{font-size:11px;color:#666;margin-top:4px;}
</style>

<div class="form-section">

<div class="mb-3">
    <label class="form-label">Nama Pelapor</label>
    <input class="form-control" readonly
           value="{{ $laporan->pengguna->pegawai->nama }}">
</div>

<hr>

<div class="mb-3">
    <label class="form-label">Nama Pelaku *</label>
    <input class="form-control" readonly value="{{ $laporan->nama_pelaku }}">
</div>

<div class="mb-3">
    <label class="form-label">Divisi Pelaku</label>
    <input class="form-control" readonly value="{{ $laporan->divisi_pelaku }}">
</div>

<hr>

<div class="mb-3">
    <label class="form-label">Judul Laporan *</label>
    <input class="form-control" readonly value="{{ $laporan->judul_aktual }}">
</div>

<div class="mb-3">
    <label class="form-label">Sumber Konflik *</label>
    <textarea class="form-control" readonly>{{ $laporan->sumber_konflik }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Kaitan antara Sumber Konflik dengan Pengambilan Keputusan *</label>
    <textarea class="form-control" readonly>{{ $laporan->kaitan_konflik }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Saran Pengendalian Konflik *</label>
    <textarea class="form-control" readonly>{{ $laporan->saran_pengendalian }}</textarea>
</div>

<hr>

<div class="mb-3">
    <label class="form-label">Tanggal Laporan</label>
    <input type="text"
           class="form-control"
           value="{{ \Carbon\Carbon::parse($laporan->tanggal_aktual)->format('d M Y') }}"
           readonly>
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <input class="form-control" readonly value="{{ $laporan->status_aktual }}">
</div>
<div class="mb-4">
    <label class="form-label fw-semibold">Timeline Status</label>
    <div class="status-timeline">
        {{-- Step 1: Diproses --}}
        <div class="status-item active">
            <div class="circle">✓</div>
            <div class="label">Diproses</div>
            <div class="time">{{ \Carbon\Carbon::parse($laporan->created_at)->format('d M Y') }}</div>
        </div>

        {{-- Step 2: Verifikasi Verifikator --}}
        <div class="status-item @if($laporan->verifikasi) @if(strpos(strtolower($laporan->verifikasi->status), 'tolak') !== false) rejected @else active @endif @endif">
            <div class="circle">
                @if($laporan->verifikasi)
                    @if(strpos(strtolower($laporan->verifikasi->status), 'tolak') !== false)✕@else✓@endif
                @endif
            </div>
            <div class="label">
                Verifikasi Verifikator
                @if($laporan->verifikasi)
                    <br><small @if(strpos(strtolower($laporan->verifikasi->status), 'tolak') !== false) class="text-danger" @else class="text-success" @endif>{{ $laporan->verifikasi->status ?? '-' }}</small>
                @endif
            </div>
            <div class="time">
                @if($laporan->verifikasi)
                    {{ \Carbon\Carbon::parse($laporan->verifikasi->tanggal)->format('d M Y') }}
                @else
                    -
                @endif
            </div>
        </div>

        {{-- Step 3: Verifikasi Inspektorat --}}
        <div class="status-item @if($laporan->verifikasi && $laporan->verifikasi->status_inspektorat) @if(strpos(strtolower($laporan->verifikasi->status_inspektorat), 'tolak') !== false) rejected @else active @endif @endif">
            <div class="circle">
                @if($laporan->verifikasi && $laporan->verifikasi->status_inspektorat)
                    @if(strpos(strtolower($laporan->verifikasi->status_inspektorat), 'tolak') !== false)✕@else✓@endif
                @endif
            </div>
            <div class="label">
                Verifikasi Inspektorat
                @if($laporan->verifikasi && $laporan->verifikasi->status_inspektorat)
                    <br><small @if(strpos(strtolower($laporan->verifikasi->status_inspektorat), 'tolak') !== false) class="text-danger" @else class="text-success" @endif>{{ $laporan->verifikasi->status_inspektorat ?? '-' }}</small>
                @endif
            </div>
            <div class="time">
                @if($laporan->verifikasi && $laporan->verifikasi->tanggal_inspektorat)
                    {{ \Carbon\Carbon::parse($laporan->verifikasi->tanggal_inspektorat)->format('d M Y') }}
                @else
                    -
                @endif
            </div>
        </div>
    </div>
</div>

@if($laporan->verifikasi && $laporan->verifikasi->status_inspektorat)
    @if($laporan->verifikasi->rekomendasi_inspektorat)
    <div class="mb-3">
        <label class="form-label">Rekomendasi Inspektorat</label>
        <textarea class="form-control" rows="3" readonly>{{ $laporan->verifikasi->rekomendasi_inspektorat }}</textarea>
    </div>
    @endif
@endif

<hr>

<h6 class="fw-semibold mb-3">Dokumen Pendukung</h6>

@if ($laporan->dokumen->count())
    <ul>
        @foreach ($laporan->dokumen as $doc)
            <li>
                <a href="{{ asset('storage/' . $doc->nama_file_aktual) }}"
                   target="_blank">
                    {{ basename($doc->nama_file_aktual) }}
                </a>
            </li>
        @endforeach
    </ul>
@else
    <p class="text-muted">Tidak ada dokumen.</p>
@endif

<a href="{{ url()->previous() }}" class="btn btn-secondary mt-4">
    ← Kembali
</a>
</div>
@endsection