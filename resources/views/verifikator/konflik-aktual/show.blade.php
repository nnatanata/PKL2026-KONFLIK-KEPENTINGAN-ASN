@extends('verifikator.layout')

@php
    $hideNavbar = true;
@endphp

@section('title', 'Detail Laporan Konflik Aktual')
@section('breadcrumb', '')

@include('verifikator.konflik-aktual.partials._styles')
@include('verifikator.konflik-aktual.partials._modal-styles')
@include('verifikator.konflik-aktual.partials._document-styles')

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
        <button class="tab-nav-item" onclick="switchTab('status')">
            Status Laporan
        </button>
    </div>

    <div class="tab-content-wrapper">
        <a href="{{ route('verifikator.konflik-aktual.index') }}" class="btn-back-modern">
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

        @include('verifikator.konflik-aktual.partials._tab-detail')
        @include('verifikator.konflik-aktual.partials._tab-dokumen')
        @include('verifikator.konflik-aktual.partials._tab-verifikasi')
        @include('partials._status-tab')
    </div>
</div>

@include('verifikator.konflik-aktual.partials._modal-confirm')
@include('verifikator.konflik-aktual.partials._modal-document')

@endsection

@include('verifikator.konflik-aktual.partials._scripts')