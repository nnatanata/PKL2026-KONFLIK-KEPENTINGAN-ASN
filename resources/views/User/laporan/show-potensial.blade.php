@extends('layouts.user')
@section('title', 'Detail Laporan Potensial')

@section('content')
<h5 class="fw-bold mb-4">Detail Laporan Potensial</h5>

<style>
.status-timeline{display:flex;justify-content:space-between;position:relative;margin:32px 0;padding:0 20px;}
.status-timeline::before{content:'';position:absolute;top:50%;left:20px;right:20px;height:4px;background:#e0e0e0;transform:translateY(-50%);z-index:1;}
.status-item{position:relative;text-align:center;flex:1;}
.status-item .circle{width:32px;height:32px;border-radius:50%;background:#e0e0e0;margin:0 auto;display:flex;align-items:center;justify-content:center;transition:background 0.3s;color:transparent;}
.status-item.active .circle{background:#28a745;color:#fff;}
.status-item .label{margin-top:8px;font-size:13px;font-weight:600;}
.status-item .time{font-size:11px;color:#666;margin-top:4px;}
</style>

<div class="form-section">

<div class="mb-3">
    <label class="form-label">Nama Pelapor</label>
    <input class="form-control" readonly
           value="{{ $laporan->pengguna->pegawai->nama }}">
</div>

<div class="mb-3">
    <label class="form-label">NIP</label>
    <input class="form-control" readonly
           value="{{ $laporan->pengguna->pegawai->nip }}">
</div>

<hr>

<div class="mb-3">
    <label class="form-label">Nama Terduga *</label>
    <input class="form-control" readonly value="{{ $laporan->nama_terduga }}">
</div>

<div class="mb-3">
    <label class="form-label">Divisi Terduga</label>
    <input class="form-control" readonly value="{{ $laporan->divisi_terduga }}">
</div>

<hr>

<div class="mb-3">
    <label class="form-label">Judul Laporan *</label>
    <input class="form-control" readonly value="{{ $laporan->judul_potensial }}">
</div>

<div class="mb-3">
    <label class="form-label">Dugaan Konflik *</label>
    <textarea class="form-control" rows="4" readonly>{{ $laporan->dugaan_konflik }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Nama Anggota Keluarga dan Kerabat dengan Potensi Konflik</label>
    <textarea class="form-control" readonly>{{ $laporan->daftar_keluarga }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Daftar Kepemilikan Saham di Perusahaan</label>
    <textarea class="form-control" readonly>{{ $laporan->kepemilikan_saham }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Aset Investasi Lain</label>
    <textarea class="form-control" readonly>{{ $laporan->aset_investasi }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Pekerjaan Lain</label>
    <textarea class="form-control" readonly>{{ $laporan->pekerjaan_lain }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Jabatan Publik Lain</label>
    <textarea class="form-control" readonly>{{ $laporan->jabatan_lain }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Keanggotaan Organisasi Kemasyarakatan</label>
    <textarea class="form-control" readonly>{{ $laporan->keanggotaan_lain }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Organisasi Nirlaba</label>
    <textarea class="form-control" readonly>{{ $laporan->organisasi_nirlaba }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Rencana Kerja Pasca Pensiun</label>
    <textarea class="form-control" readonly>{{ $laporan->rencana_pensiun }}</textarea>
</div>

<hr>

<div class="mb-3">
    <label class="form-label">Tanggal Laporan</label>
    <input type="text"
           class="form-control"
           value="{{ \Carbon\Carbon::parse($laporan->tanggal_potensial)->format('d M Y') }}"
           readonly>
</div>


<div class="mb-3">
    <label class="form-label">Status</label>
    <input class="form-control" readonly value="{{ $laporan->status_potensial }}">
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
                <a href="{{ asset('storage/' . $doc->nama_file_potensial) }}"
                   target="_blank">
                    {{ basename($doc->nama_file_potensial) }}
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