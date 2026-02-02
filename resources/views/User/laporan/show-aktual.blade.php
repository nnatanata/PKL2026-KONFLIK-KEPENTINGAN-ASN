@extends('layouts.user')
@section('title', 'Detail Laporan Aktual')

@section('content')
<h5 class="fw-bold mb-4">Detail Laporan Aktual</h5>

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
