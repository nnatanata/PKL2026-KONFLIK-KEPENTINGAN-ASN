@extends('inspektorat.layout')

@php
    $hideNavbar = true;
@endphp

@section('title', 'Detail Laporan Konflik Potensial')
@section('breadcrumb', '')

@push('styles')
    @include('inspektorat.konflik-potensial.partials._styles')
@endpush

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
        <a href="{{ route('inspektorat.konflik-potensial.index') }}" class="btn-back-modern">
            <i class="bi bi-arrow-left"></i>
            Kembali ke Daftar
        </a>

        <div id="successAlert" class="success-alert">
            <div class="success-alert-icon" id="successAlertIcon">
                <i class="bi bi-check-circle-fill" id="successAlertIconSymbol"></i>
            </div>
            <div class="success-alert-content">
                <h5>Berhasil!</h5>
                <p id="successMessage"></p>
            </div>
        </div>

        @include('inspektorat.konflik-potensial.partials._tab-detail')
        @include('inspektorat.konflik-potensial.partials._tab-dokumen')
        @include('inspektorat.konflik-potensial.partials._tab-verifikasi')
    </div>
</div>

@include('inspektorat.konflik-potensial.partials._modal-confirm')
@include('inspektorat.konflik-potensial.partials._modal-document')
@endsection

@push('scripts')
    @include('inspektorat.konflik-potensial.partials._scripts')
@endpush