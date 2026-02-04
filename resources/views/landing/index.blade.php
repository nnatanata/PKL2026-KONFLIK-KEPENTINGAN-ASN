@extends('layouts.user')

@section('title', 'SIMAKK ASN')

@section('content')

<section id="home" class="mb-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold mb-3" style="color: var(--brin-maroon);">
                Sistem Manajemen Konflik Kepentingan ASN
            </h2>

            <p class="text-muted">
                SIMAKK ASN merupakan platform resmi untuk pelaporan, pencatatan,
                dan pemantauan konflik kepentingan Aparatur Sipil Negara (ASN)
                guna mendukung tata kelola pemerintahan yang transparan
                dan berintegritas.
            </p>

            <a href="{{ route('login') }}" class="btn btn-danger px-4 py-2">
                Masuk ke Sistem
            </a>
        </div>
    </div>
</section>

<section id="tentang" class="mb-5">
    <h4 class="fw-bold mb-3" style="color: var(--brin-maroon);">
        Tentang SIMAKK ASN
    </h4>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="news-card">
                <h6>Tujuan Sistem</h6>
                <p class="small text-muted">
                    Mendukung pencegahan dan penanganan konflik kepentingan
                    di lingkungan ASN melalui mekanisme pelaporan terstruktur.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="news-card">
                <h6>Jenis Pelaporan</h6>
                <p class="small text-muted">
                    Laporan Potensial dan Laporan Aktual sesuai kondisi konflik
                    yang dilaporkan oleh pengguna.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="news-card">
                <h6>Pengawasan</h6>
                <p class="small text-muted">
                    Mendukung proses verifikasi oleh verifikator dan inspektorat
                    secara terintegrasi.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
