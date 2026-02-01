<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMAKK ASN - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --brin-red: #b11217;
            --brin-maroon: #7a0c10;
        }

        body {
            background-color: #ffffff;
        }

        .navbar {
            background-color: var(--brin-red);
        }

        .navbar-brand,
        .navbar-nav .nav-link,
        .navbar-text {
            color: #ffffff !important;
            font-weight: 500;
        }

        .navbar-nav .nav-item {
            margin: 0 10px;
        }

        .dropdown-menu {
            opacity: 0;
            transform: translateY(10px);
            visibility: hidden;
            transition: all 0.25s ease;
            display: block;
            border-top: 3px solid var(--brin-maroon);
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            transform: translateY(0);
            visibility: visible;
        }

        .dropdown-item:hover {
            background-color: #f8e5e6;
            color: var(--brin-maroon);
        }

        h5.fw-bold {
            color: var(--brin-maroon);
        }

        .lihat-semua {
            color: #000000;
            text-decoration: none;
            font-weight: 500;
        }

        .lihat-semua:hover {
            color: #000000;
            text-decoration: underline;
        }

        .card-box {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            font-weight: 600;
            border: 1px solid #eee;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .card-box .fs-2 {
            color: var(--brin-red);
        }

        .status-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 20px;
            height: 100%;
            border-left: 5px solid var(--brin-maroon);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .news-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 15px;
            height: 100%;
            border-top: 4px solid var(--brin-red);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .news-thumb {
            background-color: #f1f1f1;
            height: 120px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

@include('partials.navbar-user')

<div class="container" style="margin-top: 100px;">

    <h5 class="fw-bold mb-3">Total Pelaporan</h5>
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="card-box">
                <div class="fs-2">{{ $diproses }}</div>
                Diproses
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-box">
                <div class="fs-2">{{ $diterima }}</div>
                Diterima
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-box">
                <div class="fs-2">{{ $ditolak }}</div>
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
                <div class="status-card">
                    <h6>{{ $laporan->judul }}</h6>

                    @if ($laporan->status === 'Diproses')
                        <span class="badge bg-warning text-dark">Diproses</span>
                    @elseif ($laporan->status === 'Diterima')
                        <span class="badge bg-success">Diterima</span>
                    @elseif ($laporan->status === 'Ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </div>
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

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
