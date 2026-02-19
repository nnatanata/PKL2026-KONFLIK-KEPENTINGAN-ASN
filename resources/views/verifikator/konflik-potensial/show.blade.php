@extends('verifikator.layout')

@php
    $hideNavbar = true;
@endphp

@section('title', 'Detail Laporan Konflik Potensial')
@section('breadcrumb', '')

@include('verifikator.konflik-potensial.partials._styles')
@include('verifikator.konflik-potensial.partials._modal-styles')
@include('verifikator.konflik-potensial.partials._document-styles')

@section('content')

<div class="detail-wrapper">
    <div class="tab-navigation">
        <button class="tab-nav-item active" onclick="switchTab('detail')">
            Detail Laporan
        </button>
        <button class="tab-nav-item" onclick="switchTab('dokumen')">
            Dokumen
            @if($dokumen->count() > 0)
            <span class="doc-count-badge">{{ $dokumen->count() }}</span>
            @endif
        </button>
        <button class="tab-nav-item" onclick="switchTab('verifikasi')">
            Verifikasi
        </button>
    </div>

    <div class="tab-content-wrapper">
        <a href="{{ route('konflik-potensial.index') }}" class="btn-back-modern">
            <i class="bi bi-arrow-left"></i>
            Kembali ke Daftar
        </a>

        <div id="successAlert" class="success-alert">
            <div class="success-alert-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="success-alert-content">
                <h5>Berhasil!</h5>
                <p id="successMessage"></p>
            </div>
        </div>

        @include('verifikator.konflik-potensial.partials._tab-detail')
        @include('verifikator.konflik-potensial.partials._tab-dokumen')
        @include('verifikator.konflik-potensial.partials._tab-verifikasi')
    </div>
</div>

@include('verifikator.konflik-potensial.partials._modal-confirm')
@include('verifikator.konflik-potensial.partials._modal-document')

@endsection

@include('verifikator.konflik-potensial.partials._scripts')