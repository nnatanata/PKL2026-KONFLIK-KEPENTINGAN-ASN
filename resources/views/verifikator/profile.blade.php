@extends('verifikator.layout')

@php
    $hideProfileIcon = true;
@endphp

@section('title', 'Profil Pengguna')
@section('breadcrumb', 'Profil')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="bg-white rounded-4 shadow-sm p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="fw-bold mb-0">Informasi Profil</h5>
                <a href="{{ route('verifikator.dashboard') }}" class="btn btn-sm btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="text-center mb-4">
                <i class="bi bi-person-circle text-muted" style="font-size: 5rem;"></i>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted">Username</label>
                </div>
                <div class="col-md-8">
                    <p class="mb-0 fw-semibold">{{ $user->username }}</p>
                </div>
            </div>

            <hr class="my-3">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted">Email</label>
                </div>
                <div class="col-md-8">
                    <p class="mb-0 fw-semibold">{{ $user->email }}</p>
                </div>
            </div>

            <hr class="my-3">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted">Nama Lengkap</label>
                </div>
                <div class="col-md-8">
                    <p class="mb-0 fw-semibold">{{ $user->pegawai->nama ?? '-' }}</p>
                </div>
            </div>

            <hr class="my-3">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted">NIP</label>
                </div>
                <div class="col-md-8">
                    <p class="mb-0 fw-semibold">{{ $user->pegawai->nip ?? '-' }}</p>
                </div>
            </div>

            <hr class="my-3">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted">Jabatan</label>
                </div>
                <div class="col-md-8">
                    <p class="mb-0 fw-semibold">{{ $user->pegawai->jabatan ?? '-' }}</p>
                </div>
            </div>

            <hr class="my-3">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted">Divisi</label>
                </div>
                <div class="col-md-8">
                    <p class="mb-0 fw-semibold">{{ $user->pegawai->divisi ?? '-' }}</p>
                </div>
            </div>

            <hr class="my-3">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-muted">Role</label>
                </div>
                <div class="col-md-8">
                    <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .row .col-md-8 p {
        font-size: 1rem;
    }
    
    hr {
        opacity: 0.1;
    }
</style>
@endpush