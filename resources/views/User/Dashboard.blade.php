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

        /* navbar */
        .navbar {
            background-color: var(--brin-red);
        }

        .navbar-brand,
        .navbar-nav .nav-link,
        .navbar-text {
            color: #ffffff !important;
            font-weight: 500;
        }

        .navbar-nav .nav-link.active {
            font-weight: 600;
            border-bottom: 2px solid #ffffff;
        }

        .dropdown-menu {
            border-top: 3px solid var(--brin-maroon);
        }

        .dropdown-item:hover {
            background-color: #f8e5e6;
            color: var(--brin-maroon);
        }

        h5.fw-bold {
            color: var(--brin-maroon);
        }

        /* card box */
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

        /* status card */
        .status-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 20px;
            height: 100%;
            border-left: 5px solid var(--brin-maroon);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        /* news card */
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

        a {
            color: var(--brin-red);
        }

        a:hover {
            color: var(--brin-maroon);
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>
<body>

<!-- navbar -->
<nav class="navbar navbar-expand-lg fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('user.dashboard') }}">
            SIMAKK ASN
        </a>

        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('user.dashboard') }}">
                        Beranda
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#">
                        Pelaporan
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="#">
                                Pelaporan Potensial
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                Pelaporan Aktual
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Panduan
                    </a>
                </li>
            </ul>

            <span class="navbar-text">
                Halo, {{ auth()->user()->nama ?? 'Pengguna' }}
            </span>
        </div>
    </div>
</nav>


<div class="container" style="margin-top: 100px;">

    <!-- total laporan -->
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

    <!-- status terbaru -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold">Status Terbaru</h5>
        <a href="#" class="text-decoration-none">Lihat Semua ›</a>
    </div>

    <div class="row g-3 mb-5">
        @forelse ($statusTerbaru as $laporan)
            <div class="col-md-4">
                <div class="status-card">
                    <h6>{{ $laporan->judul }}</h6>

                    @if ($laporan->status === 'Diproses')
                        <span class="badge bg-warning text-dark">
                            Diproses
                        </span>
                    @elseif ($laporan->status === 'Diterima')
                        <span class="badge bg-success">
                            Diterima
                        </span>
                    @elseif ($laporan->status === 'Ditolak')
                        <span class="badge bg-danger">
                            Ditolak
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">
                    Belum ada laporan yang dikirim.
                </p>
            </div>
        @endforelse
    </div>

    <!-- berita terbaru -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold">Berita Terbaru</h5>
        <a href="#" class="text-decoration-none">Lihat Semua ›</a>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="news-card">
                <div class="news-thumb"></div>
                <h6>Pencegahan Konflik Kepentingan ASN</h6>
                <small>
                    Update kebijakan terbaru terkait pelaporan konflik kepentingan.
                </small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="news-card">
                <div class="news-thumb"></div>
                <h6>Sosialisasi SIMAKK ASN</h6>
                <small>
                    Pengenalan sistem manajemen konflik kepentingan ASN.
                </small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="news-card">
                <div class="news-thumb"></div>
                <h6>Integritas ASN</h6>
                <small>
                    Langkah strategis menjaga integritas aparatur sipil negara.
                </small>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
