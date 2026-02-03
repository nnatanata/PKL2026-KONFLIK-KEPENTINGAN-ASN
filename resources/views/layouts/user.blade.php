<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'SIMAKK ASN')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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

        main {
            padding-top: 100px; 
        }

        h5.fw-bold {
            color: var(--brin-maroon);
        }

        .form-section {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border: 1px solid #eee;
        }

        .status-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 20px;
            border-left: 5px solid var(--brin-maroon);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }

        /* ===== Card Total Pelaporan ===== */
        .card-box {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            font-weight: 600;
            border: 1px solid #eee;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }

        .card-box:hover {
            transform: translateY(-4px);
        }

        .lihat-semua {
            color: #000000;
            text-decoration: none;
            font-weight: 500;
        }

        .lihat-semua:hover {
            text-decoration: underline;
        }

        .news-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 15px;
            height: 100%;
            border-top: 4px solid var(--brin-red);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }

        .news-card:hover {
            transform: translateY(-4px);
        }

        .news-thumb {
            background-color: #f1f1f1;
            height: 120px;
            border-radius: 8px;
            margin-bottom: 10px;
        }


        .status-card:hover {
            transform: translateY(-4px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
        }

        .stat-diproses {
            color: #ffc107;
        }

        .stat-diterima {
            color: #198754; 
        }

        .stat-ditolak {
            color: #dc3545; 
        }
    </style>
</head>
<body>

@include('partials.navbar-user')

<main class="container">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
